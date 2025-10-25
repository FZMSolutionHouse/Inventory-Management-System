
<div id="submission-page-unique" style="all: initial; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;">
    <style scoped>
        #submission-page-unique {
            all: initial;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            display: block;
            width: 100%;
            min-height: 100vh;
            background-color: #f8f9fa;
            box-sizing: border-box;
        }
        
        #submission-page-unique *,
        #submission-page-unique *::before,
        #submission-page-unique *::after {
            box-sizing: border-box;
        }

        #submission-page-unique .mysubmissions-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        #submission-page-unique .mysubmissions-page-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px 0;
        }

        #submission-page-unique .mysubmissions-page-title {
            font-size: 32px;
            font-weight: 700;
            color: green;
            margin: 0 0 10px 0;
            padding: 0;
            border: none;
            background: none;
            text-decoration: none;
            font-family: inherit;
            display: block;
        }

        #submission-page-unique .mysubmissions-page-subtitle {
            font-size: 16px;
            color: #6c757d;
            font-weight: 400;
            margin: 0;
            padding: 0;
        }

        #submission-page-unique .mysubmissions-wrapper {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            border: 1px solid #e5e7eb;
            margin: 0;
            padding: 0;
        }

        #submission-page-unique .mysubmissions-item {
            display: flex;
            align-items: center;
            padding: 24px;
            border-bottom: 1px solid #f3f4f6;
            transition: all 0.3s ease;
            position: relative;
            margin: 0;
            background: white;
        }

        #submission-page-unique .mysubmissions-item:hover {
            background-color: #f8fafc;
            transform: translateX(4px);
        }

        #submission-page-unique .mysubmissions-item:last-child {
            border-bottom: none;
        }

        #submission-page-unique .mysubmissions-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: green;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #submission-page-unique .mysubmissions-item:hover::before {
            opacity: 1;
        }

        #submission-page-unique .mysubmissions-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            flex-shrink: 0;
            font-size: 20px;
            font-weight: 600;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            text-transform: uppercase;
            border: none;
            padding: 0;
        }

        #submission-page-unique .mysubmissions-details {
            flex: 1;
            min-width: 0;
        }

        #submission-page-unique .mysubmissions-title {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 8px 0;
            line-height: 1.3;
            padding: 0;
            border: none;
            background: none;
            text-decoration: none;
        }

        #submission-page-unique .mysubmissions-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: center;
            margin: 0 0 8px 0;
            padding: 0;
        }

        #submission-page-unique .mysubmissions-meta-item {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #6b7280;
            margin: 0;
            padding: 0;
        }

        #submission-page-unique .mysubmissions-meta-label {
            font-weight: 600;
            color: #374151;
            margin-right: 8px;
        }

        /* New Status Styling */
        #submission-page-unique .mysubmissions-status {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: inline-flex;
            align-items: center;
            margin-right: 4px;
        }

        #submission-page-unique .mysubmissions-status .mysubmissions-meta-label {
            color: #6b7280;
            font-size: 12px;
            margin-right: 6px;
        }

        #submission-page-unique .mysubmissions-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            margin-left: 20px;
            flex-shrink: 0;
        }

        #submission-page-unique .mysubmissions-date {
            font-size: 12px;
            color: #9ca3af;
            font-weight: 500;
            background: #f3f4f6;
            padding: 4px 8px;
            border-radius: 6px;
            margin: 0;
            border: none;
        }

        #submission-page-unique .mysubmissions-no-data {
            text-align: center;
            padding: 80px 40px;
            color: #6b7280;
        }

        #submission-page-unique .mysubmissions-no-data-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        #submission-page-unique .mysubmissions-no-data-text {
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 8px 0;
            color: #374151;
        }

        #submission-page-unique .mysubmissions-no-data-subtitle {
            font-size: 16px;
            opacity: 0.7;
            margin: 0 0 20px 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #submission-page-unique .mysubmissions-container {
                padding: 15px;
            }

            #submission-page-unique .mysubmissions-page-title {
                font-size: 24px;
            }

            #submission-page-unique .mysubmissions-page-subtitle {
                font-size: 14px;
            }

            #submission-page-unique .mysubmissions-item {
                padding: 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            #submission-page-unique .mysubmissions-icon {
                width: 40px;
                height: 40px;
                font-size: 16px;
                margin-right: 0;
                margin-bottom: 8px;
            }

            #submission-page-unique .mysubmissions-details {
                width: 100%;
            }

            #submission-page-unique .mysubmissions-title {
                font-size: 18px;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            #submission-page-unique .mysubmissions-title-text {
                flex: none;
            }

            #submission-page-unique .mysubmissions-status {
                align-self: flex-start;
                padding: 5px 10px;
                font-size: 12px;
            }

            #submission-page-unique .mysubmissions-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            #submission-page-unique .mysubmissions-actions {
                flex-direction: row;
                justify-content: space-between;
                width: 100%;
                margin-left: 0;
                align-items: center;
            }

            #submission-page-unique .mysubmissions-no-data {
                padding: 60px 20px;
            }

            #submission-page-unique .mysubmissions-no-data-icon {
                font-size: 48px;
            }

            #submission-page-unique .mysubmissions-no-data-text {
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {
            #submission-page-unique .mysubmissions-container {
                padding: 10px;
            }

            #submission-page-unique .mysubmissions-page-header {
                margin-bottom: 30px;
                padding: 15px 0;
            }

            #submission-page-unique .mysubmissions-item {
                padding: 16px;
            }

            #submission-page-unique .mysubmissions-meta-item {
                font-size: 13px;
            }

            #submission-page-unique .mysubmissions-title {
                font-size: 16px;
            }

            #submission-page-unique .mysubmissions-status {
                padding: 4px 8px;
                font-size: 11px;
            }
        }
    </style>

    <div class="mysubmissions-container">
        <div class="mysubmissions-page-header">
            <h1 class="mysubmissions-page-title">My Submissions</h1>
            <p class="mysubmissions-page-subtitle">Track your submitted requests</p>
        </div>
        
        @if($all_submissions && $all_submissions->count() > 0)
            <div class="mysubmissions-wrapper">
                @foreach($all_submissions as $submission)
                    <div class="mysubmissions-item">
                        <div class="mysubmissions-icon">
                            {{ strtoupper(substr($submission->name ?? 'U', 0, 1)) }}
                        </div>
                        
                        <div class="mysubmissions-details">
                            <div class="mysubmissions-title">
                                {{ $submission->subject ?? 'No Subject' }}
                            </div>
                            
                            <div class="mysubmissions-meta">
                                <div class="mysubmissions-status">
                                    <span class="mysubmissions-meta-label">Status:</span>
                                    {{ $submission->status ?? 'Not available' }}
                                </div>
                                <div class="mysubmissions-meta-item">
                                    <span class="mysubmissions-meta-label">Name:</span>
                                    {{ $submission->name ?? 'Not available' }}
                                </div>
                                <div class="mysubmissions-meta-item">
                                    <span class="mysubmissions-meta-label">Designation:</span>
                                    {{ $submission->designation ?? 'Not available' }}
                                </div>
                            </div>
                            
                            @if(isset($submission->description) && $submission->description)
                                <div class="mysubmissions-meta-item">
                                    <span class="mysubmissions-meta-label">Description:</span>
                                    {{ Str::limit($submission->description, 100) }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="mysubmissions-actions">
                            @if(isset($submission->created_at))
                                <div class="mysubmissions-date">
                                    {{ \Carbon\Carbon::parse($submission->created_at)->format('M d, Y') }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="mysubmissions-wrapper">
                <div class="mysubmissions-no-data">
                    <div class="mysubmissions-no-data-icon">📄</div>
                    <div class="mysubmissions-no-data-text">No submissions found</div>
                    <div class="mysubmissions-no-data-subtitle">
                        You haven't submitted any requests yet.
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>