 
      
@extends('layouts.public')

@section('title', 'Media Center')
 
@section('content')
 
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
 
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"> -->
    
    <style>
        :root {
            --primary-color: #1CEAB9;
            --primary-dark: #17c9a0;
            --secondary-color: #9ff291;
            --text-dark: #1a1a1a;
            --text-muted: #6b7280;
            --bg-light: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #ffffff;
            min-height: 100vh;
            color: var(--text-dark);
        }

        .main-container {
            display: flex;
            min-height: 100vh;
        }

        /* Left Side - Map */
        .map-section {
            flex: 0 0 42%;
            max-width: 42%;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .map-container {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .map-container svg {
            max-height: 90vh;
            width: auto;
        }

        /* Map Region Styles - Same as create.blade.php */
        .map-region-selectable {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .map-region-selectable:hover path {
            fill: #1CEAB9 !important;
            filter: drop-shadow(0 0 8px rgba(28, 234, 185, 0.6));
        }

        .map-region-selectable.active path {
            fill: #1CEAB9 !important;
            stroke: #0d9488 !important;
            stroke-width: 2 !important;
            filter: drop-shadow(0 0 12px rgba(28, 234, 185, 0.8));
        }

        /* Right Side - Content */
        .content-section {
            flex: 1;
            padding: 50px 60px;
            overflow-y: auto;
            background: var(--bg-light);
        }

        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .page-subtitle {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        /* Location Filter Buttons */
        .location-filters {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 35px;
            flex-wrap: wrap;
        }

        .location-btn {
            padding: 10px 26px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1.5px solid #e0e0e0;
            background: var(--card-bg);
            color: var(--text-dark);
        }

        .location-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .location-btn.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: #ffffff;
        }

        /* Places Grid */
        .places-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        /* Place Card */
        .place-card {
            background: var(--card-bg);
            border-radius: 10px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .place-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .place-name {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 18px;
            line-height: 1.4;
        }

        /* Opening Hours Section */
        .opening-hours-section {
            margin-bottom: 18px;
        }

        .section-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .section-label i {
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .hours-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .hours-column {
            text-align: left;
        }

        .hours-day-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 3px;
        }

        .hours-time {
            font-size: 0.85rem;
            color: var(--text-dark);
            line-height: 1.4;
        }

        .hours-closed {
            color: #ef4444;
        }

        /* Contact Info */
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            color: var(--text-dark);
        }

        .contact-item i {
            color: var(--primary-color);
            font-size: 0.9rem;
            width: 18px;
        }

        .contact-item a {
            color: var(--text-dark);
            text-decoration: none;
            transition: color 0.2s;
        }

        .contact-item a:hover {
            color: var(--primary-color);
        }

        /* Loading & Empty States */
        .loading-spinner {
            display: none;
            justify-content: center;
            align-items: center;
            padding: 60px;
            grid-column: 1 / -1;
        }

        .spinner {
            width: 36px;
            height: 36px;
            border: 3px solid var(--border-color);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
            display: none;
            grid-column: 1 / -1;
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 14px;
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 1400px) {
            .places-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 1200px) {
            .content-section {
                padding: 40px 30px;
            }
            
            .map-section {
                flex: 0 0 38%;
                max-width: 38%;
            }
        }

        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
            }

            .map-section {
                flex: none;
                max-width: 100%;
                width: 100%;
                height: auto;
                min-height: 350px;
                position: relative;
                padding: 30px;
            }

            .map-container svg {
                max-height: 320px;
            }

            .content-section {
                padding: 30px 20px;
            }

            .places-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.6rem;
            }

            .location-filters {
                gap: 8px;
            }

            .location-btn {
                padding: 8px 18px;
                font-size: 0.8rem;
            }

            .places-grid {
                grid-template-columns: 1fr;
            }

            .place-card {
                padding: 20px;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .place-card {
            animation: fadeInUp 0.35s ease forwards;
            opacity: 0;
        }

        .place-card:nth-child(1) { animation-delay: 0.03s; }
        .place-card:nth-child(2) { animation-delay: 0.06s; }
        .place-card:nth-child(3) { animation-delay: 0.09s; }
        .place-card:nth-child(4) { animation-delay: 0.12s; }
        .place-card:nth-child(5) { animation-delay: 0.15s; }
        .place-card:nth-child(6) { animation-delay: 0.18s; }
    </style>
 
    <div class="main-container">
        <!-- Left Side - Interactive Map -->
        <div class="map-section">
            <div class="map-container">
                <svg xmlns="http://www.w3.org/2000/svg" width="141.638" height="840.258" viewBox="0 0 141.638 840.258" id="locationMapSvg">
                    <defs>
                        <filter id="Path_5163-2" x="45.521" y="655.425" width="75.253" height="89.976" filterUnits="userSpaceOnUse">
                            <feOffset dy="3" input="SourceAlpha"></feOffset>
                            <feGaussianBlur stdDeviation="2" result="blur"></feGaussianBlur>
                            <feFlood flood-opacity="0.161"></feFlood>
                            <feComposite operator="in" in2="blur"></feComposite>
                            <feComposite in="SourceGraphic"></feComposite>
                        </filter>
                        <filter id="Path_5164-2" x="89.865" y="784.756" width="17.16" height="17.238" filterUnits="userSpaceOnUse">
                            <feOffset dy="3" input="SourceAlpha"></feOffset>
                            <feGaussianBlur stdDeviation="2" result="blur-2"></feGaussianBlur>
                            <feFlood flood-opacity="0.161"></feFlood>
                            <feComposite operator="in" in2="blur-2"></feComposite>
                            <feComposite in="SourceGraphic"></feComposite>
                        </filter>
                        <filter id="Path_5165-2" x="55.018" y="813.903" width="29.931" height="26.355" filterUnits="userSpaceOnUse">
                            <feOffset dy="3" input="SourceAlpha"></feOffset>
                            <feGaussianBlur stdDeviation="2" result="blur-3"></feGaussianBlur>
                            <feFlood flood-opacity="0.161"></feFlood>
                            <feComposite operator="in" in2="blur-3"></feComposite>
                            <feComposite in="SourceGraphic"></feComposite>
                        </filter>
                    </defs>
                    <g id="Group_4026" data-name="Group 4026" transform="translate(-84.521 -186.518)">
                        
                        <!-- South Region - Clickable -->
                        <g class="map-region-selectable" data-region-id="south-region" data-region-name="South Region" transform="matrix(1, 0, 0, 1, 84.52, 186.52)" filter="url(#Path_5163-2)">
                            <path d="M4734.592-134.38a18.08,18.08,0,0,0-9.168,2.583,87.566,87.566,0,0,0-10.766,8.115c-.136.285-2.727,2.664-4.58,3.007-.922.184-6.447.167-7.921.167-4.763.091-7.644,2.735-11.661,2.66-2.76-.09-4.373,2.923-5.1,3.646a20.287,20.287,0,0,0-2.023,5.866c-.671,7.376,2.965,15.688,7.461,16.33,3.47.177,5.647-3.729,8.519-6.616,1.626-1.425,2.71-.917,3.035-.81,5.084,2.533,6.231,9.174,6.677,10.518,1.124,4.247,10.453,16.753,18.271,16.753,6.892.529,14.165-3.627,19.446-3.387,2.18.327,4.494-7.891,6.778-8.712,4.267-2.193,6.023-5.394,6.673-10.114.5-4.294-7.312-21.677-8.487-24.279-.648-1.957-4.106-8.754-7.078-9.913-2.115-1.03-3.186-3.13-6.474-4.855A6.4,6.4,0,0,0,4734.592-134.38Z" transform="translate(-20.11 -4024.36) rotate(90)" fill="rgba(28,234,185,0.34)" stroke="rgba(255,248,248,0.45)" stroke-width="1"></path>
                        </g>
                        
                        <!-- South Region Small Islands -->
                        <g class="map-region-selectable" data-region-id="south-region" data-region-name="South Region" transform="translate(146.039 974.763)">
                            <g transform="matrix(1, 0, 0, 1, -61.52, -788.25)" filter="url(#Path_5164-2)">
                                <path d="M6506.957,59.732a5.773,5.773,0,0,0-2.023,1.618c-.461.616-.941,1.387-.4,2.021.951.885,2.4-.248,2.832-.607.9-.9,1.616-1.524,1.011-2.63A1.025,1.025,0,0,0,6506.957,59.732Z" transform="translate(160.1 -5716.05) rotate(90)" fill="#1CEAB9" stroke="#1acdce" stroke-width="1"></path>
                            </g>
                            <g transform="matrix(1, 0, 0, 1, -61.52, -788.25)" filter="url(#Path_5165-2)">
                                <path d="M6916.367,384.5c-1.165,1.165-1.218.618-1.214,1.965a.678.678,0,0,0,.684.675,4.427,4.427,0,0,0,2.553-.616c5.2-2.994,9.863-4.544,9.91-6.877l-.045-1.873-.008-.319s-3.646-5.647-7.444-5.9a12.583,12.583,0,0,1-4.236-1.011c-.592-.448-1.729-.654-1.612.806-.012,4.327.558,4.139,1.818,6.674l1.212,3.844C6918.243,382.545,6917.089,383.746,6916.367,384.5Z" transform="translate(448.66 -6097.54) rotate(90)" fill="#1CEAB9" stroke="#1acdce" stroke-width="1"></path>
                            </g>
                        </g>

                        <!-- Central Islands (non-clickable decorative) -->
                        <g transform="matrix(1, 0, 0, 1, 84.52, 186.52)">
                            <path d="M1580.188,710.424c1.66-.418,4.73,1.495,7.081.809,2.277-.873,4.78.24,9.71-2.225,2.2-1.387,2.744-3.017,2.631-4.452-.808-8.553-5.814-12.143-8.1-13.145-3.1-1.17-20.129-1.437-22.655-1.213-2.761.138-6.563.728-6.875,4.45-.021,2.805,1.682,7.825,2.023,9.908C1564.728,706.96,1572.9,711.527,1580.188,710.424Z" transform="translate(745.85 -1124.69) rotate(90)" fill="rgba(28,234,185,0.2)" stroke="rgba(255,248,248,0.3)" stroke-width="1"></path>
                        </g>
                        <g transform="matrix(1, 0, 0, 1, 84.52, 186.52)">
                            <path d="M1105,681.725c4.9-7.259,11.29,6.048,12.337-5.665.141-1.576-.777-6.269-1.006-7.485-.1-.548-.22-2.681-1.012-3.843a14.871,14.871,0,0,0-2.831-2.832,16,16,0,0,0-4.651-2.022c-1.584-.066-7.814-.747-10.114.809-2.315,2.018-9.2,6.516-9.306,10.313-.8,3.511.2,8.682,3.034,11.531,2.919,2.921,2.275.131,7.889,1.416C1101.352,684.408,1104.858,681.818,1105,681.725Z" transform="translate(717.56 -684.5) rotate(90)" fill="rgba(28,234,185,0.2)" stroke="rgba(255,248,248,0.3)" stroke-width="1"></path>
                        </g>
                        <g transform="matrix(1, 0, 0, 1, 84.52, 186.52)">
                            <path d="M2240.068,205.972c-.578,1.61-1.032,5.861-.2,7.282,1.012,1.7,1.815,7.835,3.236,10.52,2.31,4.73,7.126,10.295,15.168,9.3,7.072-.678,18-5.055,18.206-5.257,2.384-.914,4.592-5.008,4.855-7.488a19.073,19.073,0,0,0,.2-6.473c-.607-3.113-8.73-14.212-9.506-15.979,0-.009-3.663-7.017-4.855-8.5-.768-1.662-4.532-4.976-6.473-6.27a12.412,12.412,0,0,0-3.844-.607c-1.973-.323-3.89-.2-7.078,3.641-1.212,1.012-3.681,1.739-4.855,2.226a1.737,1.737,0,0,0-.809,2.224,8.12,8.12,0,0,1,.2,4.854C2244.317,196.315,2241.476,200.884,2240.068,205.972Z" transform="translate(274.17 -1754.01) rotate(90)" fill="rgba(28,234,185,0.2)" stroke="rgba(255,248,248,0.3)" stroke-width="1"></path>
                        </g>
                        <g transform="matrix(1, 0, 0, 1, 84.52, 186.52)">
                            <path d="M2879.484-137.38c-1.184.827,3.646,10.225,4.585,12.2.559,2.857.994,2.592,3.035,6.676,1.967,3.137,1.161,1.615,7.08,9.507a17.038,17.038,0,0,0,2.225,4.248c0,.007,2.623,2.63,2.63,2.63.282.355,2.419,1.618,6.675,1.618.118-.009,5.365.216,10.111-7.078.366-.871,3.3-5.017.406-9.913.04,0-2.284-4.229-2.427-5.462.18-1.979.613-5.242-2.022-7.482a18.79,18.79,0,0,0-12.945-3.641c-1.69.214-8.727,2.1-11.529,1.008C2886-133.648,2880.141-138.254,2879.484-137.38Z" transform="translate(-22.99 -2348.46) rotate(90)" fill="rgba(28,234,185,0.2)" stroke="rgba(255,248,248,0.3)" stroke-width="1"></path>
                        </g>
                        <g transform="matrix(1, 0, 0, 1, 84.52, 186.52)">
                            <path d="M1325.17-252.119c-.4,0-3.374-.548-2.831,5.057-.392,3.512-5.267,10.925-5.26,10.925a11.944,11.944,0,0,0-.2,12.745c1.361,1.835,9.425.448,11.328.4,5.366-.084,18.117.766,23.063,1.415,2.894.3,9.509-.145,9.506-2.226,0-1.653.164-4.119-2.023-5.056-.021-.022-4.37-.388-8.5-7.08-.753-1.179.443-2.25.2-3.237-.3-1.238-1.256-3.842-1.212-3.842a3.234,3.234,0,0,0-2.629-1.82c-1.359-.007-4.813-.258-6.069-1.214a21.647,21.647,0,0,0-8.5-3.439C1328.25-249.991,1326.965-252.119,1325.17-252.119Z" transform="translate(-129.5 -895.37) rotate(90)" fill="rgba(28,234,185,0.2)" stroke="rgba(255,248,248,0.3)" stroke-width="1"></path>
                        </g>
                        <g transform="matrix(1, 0, 0, 1, 84.52, 186.52)">
                            <path d="M-276.737,730.43c-4.92.922-21.5.409-25.086,1.82-3.774,1.483-12.022,4.232-13.552,7.282-1.048,2.088-2.835,3.438-3.237,5.462a14.048,14.048,0,0,1-.808,3.237c-1.791,3.111-3.259,1.905-2.026,3.844,4.013,5.512,8.571,2.366,13.755,4.451a24.308,24.308,0,0,0,7.889,2.022c13.4-.584,36.749,2.339,49.161,1.012,1.378-.259,6.259-1.58,9.1-2.022,2.16-.056,3.285-.164,3.439-3.235.217-4.322,1.582-3.329,2.429-7.688.7-3.436-.977-5.628-2.022-7.688-1.8-3.543-2.637-3.045-5.462-5.459C-253.51,724.619-264.524,728.775-276.737,730.43Z" transform="translate(781.04 625.42) rotate(90)" fill="rgba(28,234,185,0.2)" stroke="rgba(255,248,248,0.3)" stroke-width="1"></path>
                        </g>

                        <!-- Greater Male Region - Clickable -->
                        <g class="map-region-selectable" data-region-id="greater-male" data-region-name="Greater Male'" transform="translate(173.282 436.051)">
                            <g transform="matrix(1, 0, 0, 1, -88.76, -249.53)">
                                <path d="M-1079.726-21.651c3.752,3.43,6.323-1.128,5.056-5.057-.232-2.431-.881-10.556-4.854-7.28C-1082.74-31.831-1083.292-23.91-1079.726-21.651Z" transform="translate(72.44 1331.71) rotate(90)" fill="#9ff291" stroke="#1acdce" stroke-width="1"></path>
                            </g>
                            <g transform="matrix(1, 0, 0, 1, -88.76, -249.53)">
                                <path d="M-70.521-79.981c-2.938-6.418-7.09-3.065-10.922-6.27-15.6-8.417-17.629-5.355-21.441-3.639-2.487,1.12-1.079,9.9,0,12.539,1.124,2.746,6.316,3.671,8.5,4.449C-88.077-70.65-67.494-69.177-70.521-79.981Z" transform="translate(19.38 423.24) rotate(90)" fill="#9ff291" stroke="#1acdce" stroke-width="1"></path>
                            </g>
                            <g transform="matrix(1, 0, 0, 1, -88.76, -249.53)">
                                <path d="M-950.16-315.04c-4.812,1.8-9.622,6.146-8.5,11.529.757,2.32,6.082,6.631,8.233,8.358,9.27,6.121,13.6,3.8,20.09,3.782,9.8,2.749,18.9,2.655,25.489-4.043,2.064-2.432,5.09-14.166.609-15.175-10.37-2.939-6.886,1.757-18.412-10.724C-935.844-338.426-936.326-322.752-950.16-315.04Z" transform="translate(-200.91 1217.11) rotate(90)" fill="#9ff291" stroke="#1acdce" stroke-width="1"></path>
                            </g>
                        </g>

                        <!-- North Region Background -->
                        <g transform="matrix(1, 0, 0, 1, 84.52, 186.52)">
                            <path d="M-4253.717,271.979c-3.928,0-2.959-.492-6.875,3.032-3.057,1.434-4.9,2.077-6.674,3.44-12.558,1.592-8.345,21.618-25.9,20.229-2.746-.435-3.644-2.236-7.686-2.628-2.944-1.326-2.246-.742-5.462-3.034-5.1-3.632-4.979-5.145-9.306-7.486-1.961-1.188-4.853-1.887-6.475-4.045-3.211-4.274-8.368-3.107-14.983-1.013-5.376,1.759,1.411,5.823,1.022,9.3,6.493,8.455,11.522,4.428,8.9,17.6,1.93,2.506,7.15,1.1,9.509,3.235,4.161,3.758,6.509,3.471,14.771,5.867,26.372,2.83,19.59-.657,34.188-9.509,5.542-3.979,14.739-.226,20.231-5.054,9.679-.273,7.269-6.815,17.8-8.9,4.7-.944,3.226-.7,4.047-1.213l-.407-13.52-7.372-4.521C-4239.438,272.857-4246.284,273.274-4253.717,271.979Z" transform="translate(357.38 4357.41) rotate(90)" fill="rgba(28,234,185,0.2)" stroke="rgba(255,248,248,0.3)" stroke-width="1"></path>
                        </g>
                        <g transform="matrix(1, 0, 0, 1, 84.52, 186.52)">
                            <path d="M-4531.9,718.978c-7.022-3.708-13.131,4.8-14.768,9.1a22.922,22.922,0,0,0,2.225,9.713c5.465,7.006,8.6-3.6,12.335-7.281,5.3-4.057,2.606-.807,6.675-4.652C-4524.676,721.188-4528.936,720.233-4531.9,718.978Z" transform="translate(771.81 4550.23) rotate(90)" fill="rgba(28,234,185,0.2)" stroke="rgba(255,248,248,0.3)" stroke-width="1"></path>
                        </g>
                        <g transform="matrix(1, 0, 0, 1, 84.52, 186.52)">
                            <path d="M-3503.133,1147.687c-2.1-3.168-3.655-1.806-3.844,0-.606,5.791,4.4,8.336,6.474,9.1,2.692,1,2.413,2.26,3.843,2.83,2.977,1.188,3.909,3.178,8.091,3.032,8.519-.3,4.558-5.723,1.417-6.469C-3495.113,1153.862-3500.613,1151.963-3503.133,1147.687Z" transform="translate(1169.16 3584.37) rotate(90)" fill="rgba(28,234,185,0.2)" stroke="rgba(255,248,248,0.3)" stroke-width="1"></path>
                        </g>
                        <g transform="matrix(1, 0, 0, 1, 84.52, 186.52)">
                            <path d="M598.546-399.023c-5.991-5.689-4.975-13.9-6.267-22.059-.483-3.045-.429-3.642-3.44-4.853-1.809-.728-4.524-.907-5.666-1.82-1.815-1.452-2.594,1.731-3.841,2.017-4.335,1.083-3.472.343-1.416,5.463,2.694,6.424,6.8,12.73-.81,16.583-6.268,3.171-11.129,1.988-16.994,3.641-1.926.571-.531,2.559-2.023,6.07-1.768,5.945,1.163,7.66,6.88,10.932-.437-.25,8.206,4.613,10.721,6.07,1.2.743,2.955,2.734,4.653,1.82,1.873-.621,2.143-1.328,3.032-4.45C583.763-389.447,600.616-389.3,598.546-399.023Z" transform="translate(-293 -191.61) rotate(90)" fill="rgba(28,234,185,0.2)" stroke="rgba(255,248,248,0.3)" stroke-width="1"></path>
                        </g>
                        <g transform="matrix(1, 0, 0, 1, 84.52, 186.52)">
                            <path d="M-408.186,685.132l-.607,1.416c-.394,2.9-.229,5.681,2.425,6.27,2.777.617,3.085-.325,5.058-2.428a2.579,2.579,0,0,0,.607-1.618c-.08-.464-.1-2.728-.2-3.235-.229-1.1-.422-1-1.618-1.616C-403.307,683.52-406.469,682.454-408.186,685.132Z" transform="translate(739.58 706.29) rotate(90)" fill="rgba(28,234,185,0.2)" stroke="rgba(255,248,248,0.3)" stroke-width="1"></path>
                        </g>

                        <!-- North Region - Clickable -->
                        <g class="map-region-selectable" data-region-id="north-region" data-region-name="North Region" transform="translate(116.195 309.485)">
                            <g transform="matrix(1, 0, 0, 1, -31.67, -122.97)">
                                <path d="M-2828,14.943l-1.108,3.888s-5.077,4.425-7.793,6.225c-4.682,3.762-7.316,5.065-13.757,8.5a21.82,21.82,0,0,0-6.066,1.831l-.407-13.52-7.372-4.521c-.344-1.077.84-4.174,2.316-10.085.718-2.9,5.321-7.74,13.552-11.131,2.805-.934,4.1,3.437,7.485,6.272,1.472,1.542,6.948.221,10.114,2.225,2.371,1.714,1.357,1.558,2.628,4.855C-2827.763,11.434-2828.061,12.7-2828,14.943Z" transform="translate(100.95 2987.53) rotate(90)" fill="#9ff291" stroke="#1acdce" stroke-width="1"></path>
                            </g>
                            <g transform="matrix(1, 0, 0, 1, -31.67, -122.97)">
                                <path d="M-2704.978,465.918c1.438-.869,5.121-4.482,8.089-6.27,3.425-2.064,8.894.969,13.352-.2,2.692-.708,16.787.432,20.429,5.259,1.107,1.466,5.417-.989,8.093-1.415,1.69-.269,3.826-.083,4.854-1.82,1.939-3.279-.154-10.455-.815-12.486-.472-1.149-1.149-3.747-7.881-10.575-4.817-4.886-10.862-8.856-12.342-12.138-.165-.365-.763-2.443-1.417-2.828-2.133-1.26-4.459.487-5.456,2.219-2.142,2.715-1.978,5.677-4.854,7.282a50.779,50.779,0,0,0-6.676,4.45c-2.649,2.905.159,5.107-4.043,4.452-3.8-.592-2.811-2.63-5.259-2.626-1.7,0-3.785.3-5.664-.2-12.1-3.211-22.8,3.983-34.8,4.448a16.34,16.34,0,0,0-4.046,1.214c-1.714.767-2.218,3-2.225,3.843-.027,2.917.638,2.366,3.035,3.645,3.432,1.832,1.378,2.7,4.853,4.045,2.946,1.137,5.28,3.53,7.284,4.246,3.338,1.192,5.4.341,7.888.808,2.958.449,6.234-.229,8.292,1.214C-2712.668,463.614-2706.216,466.666-2704.978,465.918Z" transform="translate(497.71 2877.05) rotate(90)" fill="#9ff291" stroke="#1acdce" stroke-width="1"></path>
                            </g>
                            <g transform="matrix(1, 0, 0, 1, -31.67, -122.97)">
                                <path d="M-1364.085,7.233c1.343.72,3.91-2.03,1.011-4.248C-1365.108,1.43-1366.592,5.753-1364.085,7.233Z" transform="translate(107.2 1594.83) rotate(90)" fill="#9ff291" stroke="#1acdce" stroke-width="1"></path>
                            </g>
                            <g transform="matrix(1, 0, 0, 1, -31.67, -122.97)">
                                <path d="M-2231.169-242.783c-.838,7.254,4.161,3.967,6.065,8.5a14.528,14.528,0,0,0,5.664,4.855c19.068,7.037-.647-7.5,20.229-15.577,5.735-1.717-2.246-7.446-1.417-9.911-.462-1.522-.126-2.634-2.023-3.844-9.91-5.674-18.016,1.1-21.639,12.14C-2227.65-245.784-2229.488-246.131-2231.169-242.783Z" transform="translate(-137.56 2399.2) rotate(90)" fill="#9ff291" stroke="#1acdce" stroke-width="1"></path>
                            </g>
                            <g transform="matrix(1, 0, 0, 1, -31.67, -122.97)">
                                <path d="M-1218.529,706.087c-1.294-2.227-2.728-12.251-6.066-7.283-1.071,1.894-.542,6.977-.607,10.519a8.029,8.029,0,0,0,1.617,4.45C-1218.454,718.594-1215.762,710.99-1218.529,706.087Z" transform="translate(752.65 1464.65) rotate(90)" fill="#9ff291" stroke="#1acdce" stroke-width="1"></path>
                            </g>
                        </g>

                    </g>
                </svg>
            </div>
        </div>

        <!-- Right Side - Content -->
        <div class="content-section">
            <div class="page-header">
                <h1 class="page-title">Locations</h1>
                <p class="page-subtitle">Please select one of the highlighted atolls</p>
            </div>

            <!-- Location Filter Buttons -->
            <div class="location-filters">
                @foreach($locations as $location)
                <button type="button" 
                        class="location-btn {{ $loop->first ? 'active' : '' }}" 
                        data-location-id="{{ $location->id }}"
                        data-location-slug="{{ $location->slug }}"
                        data-map-id="{{ $location->map_id }}">
                    {{ $location->name }}
                </button>
                @endforeach
            </div>

            <!-- Places Grid -->
            <div class="places-grid" id="placesGrid">
                <!-- Loading Spinner -->
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner"></div>
                </div>

                <!-- Empty State -->
                <div class="empty-state" id="emptyState">
                    <i class="bi bi-geo-alt"></i>
                    <p>No places found in this location</p>
                </div>

                <!-- Places will be loaded here dynamically -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const locationBtns = document.querySelectorAll('.location-btn');
            const mapRegions = document.querySelectorAll('.map-region-selectable');
            const placesGrid = document.getElementById('placesGrid');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const emptyState = document.getElementById('emptyState');

            // Build map of location slugs to map IDs
            const locationMapIds = {};
            locationBtns.forEach(btn => {
                locationMapIds[btn.dataset.locationSlug] = btn.dataset.mapId;
            });

            // Load first location by default
            if (locationBtns.length > 0) {
                const firstBtn = locationBtns[0];
                loadPlaces(firstBtn.dataset.locationSlug);
                
                // Also set map region active
                const mapId = firstBtn.dataset.mapId;
                if (mapId) {
                    setMapRegionActive(mapId);
                }
            }

            // Set map region active by map_id
            function setMapRegionActive(mapId) {
                mapRegions.forEach(region => {
                    if (region.dataset.regionId === mapId) {
                        region.classList.add('active');
                    } else {
                        region.classList.remove('active');
                    }
                });
            }

            // Location button click handlers
            locationBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Update active button
                    locationBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    // Update active map region
                    const mapId = this.dataset.mapId;
                    if (mapId) {
                        setMapRegionActive(mapId);
                    }

                    // Load places
                    loadPlaces(this.dataset.locationSlug);
                });
            });

            // Map region click handlers
            mapRegions.forEach(region => {
                region.addEventListener('click', function() {
                    const regionId = this.dataset.regionId;
                    
                    // Find the corresponding location button
                    let matchedBtn = null;
                    locationBtns.forEach(btn => {
                        if (btn.dataset.mapId === regionId) {
                            matchedBtn = btn;
                        }
                    });

                    if (matchedBtn) {
                        // Update active map region
                        setMapRegionActive(regionId);

                        // Update active button
                        locationBtns.forEach(b => b.classList.remove('active'));
                        matchedBtn.classList.add('active');

                        // Load places
                        loadPlaces(matchedBtn.dataset.locationSlug);
                    }
                });
            });

            // Load places via AJAX
            function loadPlaces(slug) {
                showLoading();

                fetch(`/cms/api/places/location/slug/${slug}`)
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        
                        if (data.places && data.places.length > 0) {
                            renderPlaces(data.places);
                        } else {
                            showEmpty();
                        }
                    })
                    .catch(error => {
                        console.error('Error loading places:', error);
                        hideLoading();
                        showEmpty();
                    });
            }

            // Render places to grid
            function renderPlaces(places) {
                // Remove old place cards
                const oldCards = placesGrid.querySelectorAll('.place-card');
                oldCards.forEach(card => card.remove());
                
                emptyState.style.display = 'none';

                places.forEach((place, index) => {
                    const card = createPlaceCard(place, index);
                    placesGrid.appendChild(card);
                });
            }

            // Create place card HTML
            function createPlaceCard(place, index) {
                const card = document.createElement('div');
                card.className = 'place-card';
                card.style.animationDelay = (index * 0.03) + 's';

                // Format opening hours
                let hoursHtml = formatOpeningHours(place.opening_hours);

                card.innerHTML = `
                    <h3 class="place-name">${place.name}</h3>
                    
                    ${hoursHtml ? `
                    <div class="opening-hours-section">
                        <div class="section-label">
                            <i class="bi bi-clock"></i>
                            <span>Opening Hours</span>
                        </div>
                        ${hoursHtml}
                    </div>
                    ` : ''}
                    
                    <div class="contact-info">
                        ${place.phone_number ? `
                        <div class="contact-item">
                            <i class="bi bi-telephone-fill"></i>
                            <a href="tel:${place.phone_number}">${place.phone_number}</a>
                        </div>
                        ` : ''}
                        ${place.email ? `
                        <div class="contact-item">
                            <i class="bi bi-envelope-fill"></i>
                            <a href="mailto:${place.email}">${place.email}</a>
                        </div>
                        ` : ''}
                        ${place.address ? `
                        <div class="contact-item">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>${place.address}</span>
                        </div>
                        ` : ''}
                    </div>
                `;

                return card;
            }

            // Format opening hours into SUN-THUR and FRI-SAT columns
            function formatOpeningHours(openingHours) {
                if (!openingHours || openingHours.length === 0) return '';

                let sunThurHours = '';
                let friSatHours = '';

                openingHours.forEach(schedule => {
                    if (!schedule.days) return;
                    
                    const daysLower = schedule.days.map(d => d.toLowerCase());
                    const timeText = schedule.closed ? 
                        `<span class="hours-closed">Closed</span>` : 
                        `${schedule.open} – ${schedule.close}`;

                    // Check for weekday days (Sun-Thu)
                    const weekdayDays = ['sun', 'sunday', 'mon', 'monday', 'tue', 'tuesday', 'wed', 'wednesday', 'thu', 'thursday'];
                    const weekendDays = ['fri', 'friday', 'sat', 'saturday'];
                    
                    const hasWeekdays = daysLower.some(d => weekdayDays.includes(d));
                    const hasWeekend = daysLower.some(d => weekendDays.includes(d));

                    if (hasWeekdays && !hasWeekend) {
                        sunThurHours = timeText;
                    } else if (hasWeekend && !hasWeekdays) {
                        const hasFri = daysLower.some(d => ['fri', 'friday'].includes(d));
                        const hasSat = daysLower.some(d => ['sat', 'saturday'].includes(d));
                        
                        if (hasFri && hasSat) {
                            friSatHours = timeText;
                        } else if (hasFri) {
                            friSatHours = schedule.closed ? 
                                'Friday - Closed' : 
                                `Friday - ${schedule.open}-${schedule.close}`;
                        } else if (hasSat) {
                            const satText = schedule.closed ? 
                                'Saturday - Closed' : 
                                `Saturday - ${schedule.open}-${schedule.close}`;
                            friSatHours = friSatHours ? friSatHours + ', ' + satText : satText;
                        }
                    }
                });

                // Handle separate Friday/Saturday entries
                let friInfo = '';
                let satInfo = '';
                
                openingHours.forEach(schedule => {
                    if (!schedule.days) return;
                    const daysLower = schedule.days.map(d => d.toLowerCase());
                    
                    if (daysLower.length === 1) {
                        if (daysLower[0] === 'fri' || daysLower[0] === 'friday') {
                            friInfo = schedule.closed ? 'Closed' : `${schedule.open}-${schedule.close}`;
                        }
                        if (daysLower[0] === 'sat' || daysLower[0] === 'saturday') {
                            satInfo = schedule.closed ? 'Closed' : `${schedule.open}-${schedule.close}`;
                        }
                    }
                });

                if ((friInfo || satInfo) && !friSatHours) {
                    let combined = '';
                    if (friInfo) combined += `Friday - ${friInfo}`;
                    if (friInfo && satInfo) combined += ',<br>';
                    if (satInfo) combined += `Saturday - ${satInfo}`;
                    if (combined) friSatHours = combined;
                }

                // Fallback: if still no proper separation, use first two schedules
                if (!sunThurHours && !friSatHours && openingHours.length > 0) {
                    const firstSchedule = openingHours[0];
                    sunThurHours = firstSchedule.closed ? 
                        '<span class="hours-closed">Closed</span>' : 
                        `${firstSchedule.open} – ${firstSchedule.close}`;
                    
                    if (openingHours.length > 1) {
                        const secondSchedule = openingHours[1];
                        friSatHours = secondSchedule.closed ? 
                            '<span class="hours-closed">Closed</span>' : 
                            `${secondSchedule.open} – ${secondSchedule.close}`;
                    }
                }

                return `
                    <div class="hours-grid">
                        <div class="hours-column">
                            <div class="hours-day-label">SUN - THUR</div>
                            <div class="hours-time">${sunThurHours || '-'}</div>
                        </div>
                        <div class="hours-column">
                            <div class="hours-day-label">FRI - SAT</div>
                            <div class="hours-time">${friSatHours || '-'}</div>
                        </div>
                    </div>
                `;
            }

            function showLoading() {
                loadingSpinner.style.display = 'flex';
                const oldCards = placesGrid.querySelectorAll('.place-card');
                oldCards.forEach(card => card.remove());
                emptyState.style.display = 'none';
            }

            function hideLoading() {
                loadingSpinner.style.display = 'none';
            }

            function showEmpty() {
                const oldCards = placesGrid.querySelectorAll('.place-card');
                oldCards.forEach(card => card.remove());
                emptyState.style.display = 'block';
            }
        });
    </script>
 @endsection