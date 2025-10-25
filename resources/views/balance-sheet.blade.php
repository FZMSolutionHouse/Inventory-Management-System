@extends('layouts.adminmaster')

@section('content')
<style>
    .dashboard-container {
        padding: 20px;
        background: #f8fafc;
        min-height: 100vh;
        zoom: 90%; /* Apply 90% zoom for compact layout */
    }

    /* Compact Professional Statistics Cards */
    .stats-container-pro {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Force 4 columns in one row */
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card-pro {
        background: white;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 80px;
    }

    .stat-card-pro:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .card-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .card-icon {
        width: 24px;
        height: 24px;
        color: white;
    }

    .card-content {
        flex: 1;
    }

    .card-title {
        font-size: 13px;
        font-weight: 500;
        color: #64748b;
        margin: 0 0 4px 0;
    }

    .card-value {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 2px 0;
        line-height: 1;
    }

    .card-subtitle {
        font-size: 11px;
        color: #94a3b8;
        margin: 0;
    }

    /* Balance Sheet Table */
    .balance-sheet-container {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .balance-sheet-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        text-align: center;
    }

    .balance-sheet-form {
        display: grid;
        gap: 15px;
    }

    .form-section {
        background: #f8fafc;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 12px;
        padding-bottom: 5px;
    
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 5px;
    }

    .form-input {
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .readonly-input {
        background-color: #f3f4f6;
        color: #6b7280;
        cursor: not-allowed;
    }

    .calculated-field {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        font-weight: 600;
    }

    .remaining-balance {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        font-weight: 600;
    }

    .negative-balance {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        font-weight: 600;
    }

    .save-button {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
    }

    .save-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .inventory-reference {
        background: #fffbeb;
        border: 1px solid #fbbf24;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .inventory-title {
        font-size: 14px;
        font-weight: 600;
        color: #92400e;
        margin-bottom: 10px;
    }

    .inventory-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 10px;
        font-size: 12px;
    }

    .inventory-item {
        padding: 8px;
        background: white;
        border-radius: 4px;
        border: 1px solid #fbbf24;
    }

    .alert-success {
        background: #d1fae5;
        border: 1px solid #10b981;
        color: #065f46;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-error {
        background: #fee2e2;
        border: 1px solid #ef4444;
        color: #991b1b;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    /* Responsive design */
    @media (max-width: 1200px) {
        .stats-container-pro {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-container-pro {
            grid-template-columns: 1fr;
        }
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    {{-- Display messages --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error') || isset($error))
        <div class="alert-error">
            {{ session('error') ?? $error }}
        </div>
    @endif

    <!-- Summary Statistics Cards -->
    <div class="stats-container-pro">
        <div class="stat-card-pro">
            <div class="card-icon-wrapper" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <svg class="card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="card-content">
                <p class="card-title">Inventory Value</p>
                <p class="card-value">${{ number_format($balanceSheet->total_inventory_value ?? 0, 2) }}</p>
                <p class="card-subtitle">Current stock value</p>
            </div>
        </div>

        <div class="stat-card-pro">
            <div class="card-icon-wrapper" style="background: linear-gradient(135deg, #38ef7d 0%, #11998e 100%);">
                <svg class="card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
            <div class="card-content">
                <p class="card-title">Total Fund</p>
                <p class="card-value">${{ number_format($balanceSheet->total_yearly_fund ?? 0, 2) }}</p>
                <p class="card-subtitle">Available fund</p>
            </div>
        </div>

        <div class="stat-card-pro">
            <div class="card-icon-wrapper" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);">
                <svg class="card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="card-content">
                <p class="card-title">Total Costs</p>
                <p class="card-value">${{ number_format($balanceSheet->calculated_total_cost ?? 0, 2) }}</p>
                <p class="card-subtitle">All expenses</p>
            </div>
        </div>

        <div class="stat-card-pro">
            <div class="card-icon-wrapper" style="background: {{ ($balanceSheet->remaining_balance ?? 0) >= 0 ? 'linear-gradient(135deg, #5ee7df 0%, #b490ca 100%)' : 'linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%)' }};">
                <svg class="card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="card-content">
                <p class="card-title">Balance</p>
                <p class="card-value" style="color: {{ ($balanceSheet->remaining_balance ?? 0) >= 0 ? '#10b981' : '#ef4444' }}">
                    ${{ number_format($balanceSheet->remaining_balance ?? 0, 2) }}
                </p>
                <p class="card-subtitle">{{ ($balanceSheet->remaining_balance ?? 0) >= 0 ? 'Profit' : 'Loss' }}</p>
            </div>
        </div>
    </div>

    <!-- Inventory Reference -->
    @if($inventoryItems->isNotEmpty())
    <div class="inventory-reference">
        <div class="inventory-title">Current Inventory Items Reference</div>
        <div class="inventory-grid">
            @foreach($inventoryItems as $item)
            <div class="inventory-item">
                <strong>{{ $item->item_name }}</strong><br>
                Qty: {{ $item->quantity }} | Price: ${{ number_format($item->price, 2) }}<br>
                Value: ${{ number_format($item->price, 2) }}
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Balance Sheet Form -->
    <div class="balance-sheet-container">
        <div class="balance-sheet-title">
            Company Balance Sheet - {{ $balanceSheet->financial_year ?? date('Y') . '-' . (date('Y') + 1) }}
        </div>

        <form action="{{ route('balance-sheet.update') }}" method="POST" class="balance-sheet-form" id="balanceSheetForm">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="financial_year" value="{{ $balanceSheet->financial_year ?? date('Y') . '-' . (date('Y') + 1) }}">

            <!-- Assets Section -->
            <div class="form-section">
                <div class="section-title">Assets</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Total Inventory Value (Auto-calculated)</label>
                        <input type="number" step="0.01" class="form-input readonly-input" value="{{ $balanceSheet->total_inventory_value ?? 0 }}" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Office Equipment Cost</label>
                        <input type="number" step="0.01" name="office_equipment_cost" class="form-input cost-input" value="{{ $balanceSheet->office_equipment_cost ?? 0 }}" min="0">
                    </div>
                </div>
            </div>

            <!-- Expenses Section -->
            <div class="form-section">
                <div class="section-title">Operating Expenses</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Rent Expenses</label>
                        <input type="number" step="0.01" name="rent_expenses" class="form-input cost-input" value="{{ $balanceSheet->rent_expenses ?? 0 }}" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Utility Expenses</label>
                        <input type="number" step="0.01" name="utility_expenses" class="form-input cost-input" value="{{ $balanceSheet->utility_expenses ?? 0 }}" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Marketing Expenses</label>
                        <input type="number" step="0.01" name="marketing_expenses" class="form-input cost-input" value="{{ $balanceSheet->marketing_expenses ?? 0 }}" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Maintenance Cost</label>
                        <input type="number" step="0.01" name="maintenance_cost" class="form-input cost-input" value="{{ $balanceSheet->maintenance_cost ?? 0 }}" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Other Expenses</label>
                        <input type="number" step="0.01" name="other_expenses" class="form-input cost-input" value="{{ $balanceSheet->other_expenses ?? 0 }}" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Total Salary Expenses</label>
                        <input type="number" step="0.01" name="total_salary_expenses" class="form-input cost-input" value="{{ $balanceSheet->total_salary_expenses ?? 0 }}" min="0">
                    </div>
                </div>
            </div>

            <!-- Fund & Calculations Section -->
            <div class="form-section">
                <div class="section-title">Financial Summary</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Total Yearly Fund</label>
                        <input type="number" step="0.01" name="total_yearly_fund" class="form-input fund-input" value="{{ $balanceSheet->total_yearly_fund ?? 0 }}" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Total Cost (Auto-calculated)</label>
                        <input type="number" step="0.01" id="totalCost" class="form-input calculated-field" value="{{ $balanceSheet->calculated_total_cost ?? 0 }}" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Remaining Balance (Auto-calculated)</label>
                        <input type="number" step="0.01" id="remainingBalance" class="form-input remaining-balance" value="{{ $balanceSheet->remaining_balance ?? 0 }}" readonly>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="form-section">
                <div class="section-title">Notes</div>
                <div class="form-group">
                    <label class="form-label">Additional Notes</label>
                    <textarea name="notes" class="form-input" rows="3" placeholder="Add any additional notes or comments...">{{ $balanceSheet->notes ?? '' }}</textarea>
                </div>
            </div>

            <button type="submit" class="save-button">
                💾 Save Balance Sheet Changes
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all input elements
    const costInputs = document.querySelectorAll('.cost-input');
    const fundInput = document.querySelector('.fund-input');
    const totalCostField = document.getElementById('totalCost');
    const remainingBalanceField = document.getElementById('remainingBalance');
    const inventoryValue = {{ $balanceSheet->total_inventory_value ?? 0 }};

    // Function to calculate totals
    function calculateTotals() {
        let totalCost = parseFloat(inventoryValue);
        
        // Add all cost inputs
        costInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            totalCost += value;
        });

        // Update total cost field
        totalCostField.value = totalCost.toFixed(2);

        // Calculate remaining balance
        const totalFund = parseFloat(fundInput.value) || 0;
        const remainingBalance = totalFund - totalCost;
        
        // Update remaining balance field
        remainingBalanceField.value = remainingBalance.toFixed(2);
        
        // Update balance field styling based on positive/negative value
        if (remainingBalance >= 0) {
            remainingBalanceField.className = 'form-input remaining-balance';
        } else {
            remainingBalanceField.className = 'form-input negative-balance';
        }
    }

    // Add event listeners to all inputs that affect calculations
    [...costInputs, fundInput].forEach(input => {
        input.addEventListener('input', calculateTotals);
        input.addEventListener('change', calculateTotals);
    });

    // Initial calculation
    calculateTotals();

    // Form submission confirmation
    document.getElementById('balanceSheetForm').addEventListener('submit', function(e) {
        const totalFund = parseFloat(fundInput.value) || 0;
        const totalCost = parseFloat(totalCostField.value) || 0;
        
        if (totalFund === 0) {
            if (!confirm('Total Yearly Fund is set to $0. Are you sure you want to continue?')) {
                e.preventDefault();
                return;
            }
        }
        
        if (totalCost > totalFund) {
            if (!confirm('Your total costs exceed your available fund, resulting in a loss. Do you want to proceed?')) {
                e.preventDefault();
                return;
            }
        }
    });

    // Page load animations
    const cards = document.querySelectorAll('.stat-card-pro');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    const sections = document.querySelectorAll('.form-section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            section.style.transition = 'all 0.8s ease';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, 600 + (index * 200));
    });
});
</script>

@endsection