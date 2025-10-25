<?php
namespace App\Http\Controllers;

use App\Models\DigitalSign;
use Creagia\LaravelSignPad\Signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DigitalSignController extends Controller
{
    public function create()
    {
        return view('digitalSignature');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'itemname' => 'required|string|min:3',
            'description' => 'required|string',
            'sign' => 'required',
        ]);

        // Process signature data first
        $signatureData = str_replace('data:image/png;base64,', '', $validatedData['sign']);
        $signatureData = base64_decode($signatureData);
        $imageName = 'signatures/' . Str::uuid() . '.png';
        Storage::disk('public')->put($imageName, $signatureData);

        // Prepare data for database insertion with correct field names
        $digitalSignData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'Related_item' => $validatedData['itemname'], // Map to correct database field
            'description' => $validatedData['description'],
            'signature' => $imageName, // Store the signature file path
        ];

        // Create digital sign record
        $digitalSign = DigitalSign::create($digitalSignData);

        // Create signature record using the signature package
        $signature = new Signature();
        $signature->model_type = DigitalSign::class;
        $signature->model_id = $digitalSign->id;
        $signature->uuid = Str::uuid();
        $signature->filename = $imageName;
        $signature->document_filename = null;
        $signature->certified = false;
        $signature->from_ips = json_encode([request()->ip()]);
        $signature->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Employment Agreement submitted successfully!');
    }

    public function show($id)
    {
        $digitalSign = DigitalSign::with('signature')->findOrFail($id);
        return view('show', compact('digitalSign'));
    }
}