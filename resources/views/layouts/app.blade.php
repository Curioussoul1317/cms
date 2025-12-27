<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - WAMCO CMS</title>
    
    <!-- Tabler CSS -->
    <link rel="stylesheet" href="https://unpkg.com/@tabler/icons@1.119.0/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css">
    
    <style>
        .cmsalert {
            z-index: 300;
            position: absolute;
            right: 23px;
            top: 65px;
            width: 450px;
            background-color: #ffffff;
        }
        
        .content-block.sortable-ghost {
            opacity: 0.4;
        }
        
        .drag-handle {
            cursor: move;
            touch-action: none;
        }
    </style>
</head>

<body>
    <div class="page">
        <!-- Navbar -->
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="/">
                        <span class="avatar">
                           <svg width="50" height="50" viewBox="0 0 60 60" fill="none" xmlns="https://www.w3.org/2000/svg" class="item"><path fill-rule="evenodd" clip-rule="evenodd" d="M51.4755 38.2565C51.4755 38.2565 51.4304 38.3341 51.3553 38.4743L51.0099 39.0825C50.7196 39.5831 50.3091 40.2264 49.8686 40.8522C49.2795 41.6857 48.6418 42.4839 47.959 43.2426L46.0193 41.5255C46.6174 40.8319 47.1756 40.1049 47.6912 39.3478C48.0741 38.7797 48.4295 38.1914 48.6798 37.7434L48.9751 37.2002L49.0903 36.98L51.4755 38.2565Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M43.3512 47.2546L43.1435 47.3922L42.5478 47.7702C42.0648 48.0731 41.404 48.456 40.7258 48.8064C39.8214 49.2699 38.8904 49.6794 37.9376 50.0329L37.0967 47.8227C37.9529 47.4847 38.7886 47.0969 39.5995 46.6613C40.2077 46.3335 40.7958 45.978 41.2288 45.6927C41.4416 45.55 41.6193 45.4424 41.7419 45.3473L41.9471 45.2046L43.3437 47.2546H43.3512Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M32.0359 51.4318L31.7857 51.4594L31.0974 51.5195C30.5292 51.562 29.7684 51.5945 29.01 51.587C28.6371 51.587 28.2592 51.572 27.8963 51.552C27.5334 51.532 27.2105 51.5094 26.9277 51.4844C26.3596 51.4318 25.9841 51.3793 25.9841 51.3793L26.2344 49.2542C26.2344 49.2542 26.5773 49.2943 27.0979 49.3318C27.3482 49.3493 27.661 49.3669 27.9864 49.3769C28.3117 49.3869 28.6521 49.3919 29.005 49.3769C29.6983 49.3769 30.3916 49.3268 30.9097 49.2793L31.5304 49.2117L31.7806 49.1816L32.0309 51.4193L32.0359 51.4318Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M20.1051 49.8824L19.8723 49.7898L19.2366 49.5245C18.716 49.2992 18.0328 48.9764 17.367 48.6184C16.4798 48.1394 15.6216 47.6087 14.7966 47.029L15.8854 45.4546C16.6568 45.9724 17.4573 46.4455 18.283 46.8713C18.9037 47.1892 19.5345 47.4745 20.02 47.6723L20.6057 47.9026L20.8384 47.9902L20.1051 49.8824Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M10.3241 42.9943L10.1614 42.8015L9.72593 42.2734C9.36803 41.8354 8.91502 41.2346 8.49205 40.6114C7.92948 39.7804 7.41634 38.9171 6.95532 38.0258L8.45701 37.2373C8.9018 38.0592 9.39488 38.8541 9.93367 39.6177C10.3366 40.1884 10.7696 40.739 11.1075 41.1395L11.5129 41.6226L11.6781 41.8078L10.3216 42.9943H10.3241Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M4.87549 32.4036L4.82043 32.1533C4.7879 31.9931 4.73784 31.7628 4.68027 31.4875C4.57015 30.9343 4.45002 30.1934 4.36492 29.45C4.25656 28.4576 4.20558 27.4597 4.21225 26.4614H5.6764C5.68911 27.4006 5.75597 28.3383 5.87662 29.2698C5.96672 29.9657 6.09437 30.659 6.20699 31.1721C6.26706 31.4224 6.31712 31.6427 6.34965 31.7904C6.38219 31.938 6.40972 32.0407 6.40972 32.0407L4.87549 32.4061V32.4036Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M4.97559 20.5471C4.97559 20.5471 5.06318 20.1992 5.22587 19.6535C5.38855 19.1079 5.61631 18.402 5.88661 17.7112C6.25013 16.7846 6.66799 15.8803 7.13802 15.0029L8.23425 15.5786C7.80696 16.4194 7.42923 17.2844 7.10298 18.1693C6.8527 18.8326 6.64997 19.5084 6.51231 20.019C6.37466 20.5296 6.29207 20.88 6.29207 20.88L4.98059 20.5471H4.97559Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M20.2729 3.54408C20.2729 3.54408 20.6108 3.41642 21.1439 3.24121C21.677 3.066 22.3803 2.86075 23.1011 2.69055C24.0597 2.46559 25.0308 2.29842 26.0094 2.18994L26.1045 2.97088C25.1596 3.09339 24.2228 3.27141 23.2989 3.50403C22.6081 3.68425 21.9248 3.897 21.4217 4.07472C20.9187 4.25243 20.5833 4.38509 20.5833 4.38509L20.2729 3.54408Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M31.8909 2.22998C31.8909 2.22998 32.2513 2.27503 32.7994 2.36514C33.3475 2.45525 34.0683 2.60043 34.7791 2.78065C35.7296 3.02359 36.6648 3.32281 37.5798 3.67673L37.382 4.20487C36.4815 3.87653 35.5622 3.60238 34.629 3.38388C33.9307 3.21868 33.2249 3.09352 32.6918 3.01593C32.1587 2.93834 31.8008 2.90079 31.8008 2.90079L31.8859 2.22998H31.8909Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M42.7431 6.44531C42.7431 6.44531 43.0409 6.65056 43.4814 6.98597C43.9219 7.32137 44.4825 7.77942 45.0306 8.27002C45.7545 8.92384 46.4398 9.61918 47.0829 10.3525L46.8327 10.5778C45.5392 9.15751 44.0806 7.89704 42.4878 6.82327L42.7381 6.45532L42.7431 6.44531Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M50.3616 15.1755C51.2536 16.904 51.9319 18.7347 52.3814 20.6271L52.2713 20.6522C52.0285 19.7174 51.7302 18.798 51.3778 17.8988C51.0243 16.9988 50.6182 16.1204 50.1614 15.2682L50.3616 15.1655V15.1755Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M21.7544 49.147C22.275 46.3562 23.7767 42.7017 25.8565 41.265C24.2848 38.8371 24.1246 35.5606 24.3073 33.0451C26.3646 36.7195 28.8975 40.4115 32.3313 42.8069C28.5295 43.5903 24.938 45.9457 21.7544 49.157V49.147ZM33.5026 40.4715C31.1125 38.782 28.9801 36.1588 26.6474 32.0314L22.24 24.2319L21.4716 32.4544C21.1938 35.443 21.4566 38.1287 22.27 40.4015C20.3554 42.6241 19.0964 45.8781 18.5508 48.4687L16.1206 60.0001L23.9669 51.585C26.9703 48.3611 30.1213 46.3712 33.1147 45.6653L38.9162 44.3037L33.5026 40.4791V40.4715Z" fill="rgba(146, 199, 64, 1)" stroke-width="0.5" stroke="#92C740" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M49.3056 31.2876C48.0141 32.2538 45.8016 32.0385 43.9095 31.5955C46.1921 30.344 48.2344 28.7921 49.1654 26.4368C50.2792 29.513 52.2113 32.444 54.3838 34.947C52.8345 34.4014 50.5169 33.0197 49.2956 31.2901L49.3056 31.2876ZM55.3248 33.6004C53.2525 31.22 51.6832 28.682 50.8048 26.3041L49.0102 21.4482L47.456 25.0701C46.7427 26.7346 45.2886 28.0737 42.6281 29.4379L36.8716 32.389L44.0497 33.9358C45.2587 34.2242 46.5019 34.3438 47.7438 34.2913C48.2989 34.2575 48.8474 34.1524 49.3757 33.9784C50.8464 35.3673 52.5892 36.436 54.4939 37.1172L60.0001 38.9669L55.3474 33.6204L55.3248 33.6004Z" fill="rgba(146, 199, 64, 1)" stroke-width="0.5" stroke="#92C740" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M14.6365 16.5725C13.8556 12.9131 11.6606 9.37382 8.85746 6.22001C11.3603 7.2888 14.7191 9.31625 16.0956 11.3137C18.3481 10.7004 21.3891 11.4163 23.7567 12.2047C20.483 12.9231 17.0191 14.0945 14.6365 16.5725ZM23.9619 10.1673C22.4323 9.6198 20.8556 9.21427 19.2517 8.95582C18.446 8.83159 17.6316 8.77216 16.8164 8.7781C14.7816 6.86079 11.9209 5.2163 9.67338 4.23261L0 0L6.40721 7.18618C9.21787 10.3375 11.0124 13.5338 11.593 16.5049L12.8995 23.0729L17.1117 18.3872C18.7711 16.5525 21.2539 15.326 25.0281 14.3949L31.5355 12.7929L23.9619 10.1673Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path></svg>
                        </span>
                        WAMCO Content management system
                    </a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item d-none d-md-flex me-3">
                    <div class="btn-list">
                      <a href="{{ route('sync.index') }}" class="btn" target="_blank" rel="noreferrer">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-import"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" /><path d="M4 6v6c0 1.657 3.582 3 8 3c.856 0 1.68 -.05 2.454 -.144m5.546 -2.856v-6" /><path d="M4 12v6c0 1.657 3.582 3 8 3c.171 0 .341 -.002 .51 -.006" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
                       Data Base Sync
                      </a>
                      <a href=" " class="btn" target="_blank" rel="noreferrer">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-diff"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M12 10l0 4" /><path d="M10 12l4 0" /><path d="M10 17l4 0" /></svg>
                       File Sync
                      </a>
                    </div>
                  </div>
                    <div class="nav-item dropdown d-none d-md-flex me-3">
                        <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                            <i class="ti ti-bell icon"></i>
                            <span class="badge bg-red"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Notifications</h3>
                                </div>
                                <div class="list-group list-group-flush list-group-hoverable">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="status-dot status-dot-animated bg-green d-block"></span>
                                            </div>
                                            <div class="col text-truncate">
                                                <span class="text-body d-block">System is running smoothly</span>
                                                <div class="d-block text-muted text-truncate mt-n1">
                                                    All services operational
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm bg-blue-lt">WA</span>
                            <div class="d-none d-xl-block ps-2">
                                <div>WAMCO Admin</div>
                                <div class="mt-1 small text-muted">Administrator</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="#" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        








        <header class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar">
            <div class="container-xl">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('categories.hierarchy') }}" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title">
                      Pages
                    </span>
                  </a>
                </li>
                <li class="nav-item   dropdown">
                  <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/layout-2 -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M4 13m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /></svg>
                    </span>
                    <span class="nav-link-title">
                    Corporate Profile
                    </span>
                  </a>
                  <div class="dropdown-menu">
                    <div class="dropdown-menu-columns">
                      <div class="dropdown-menu-column">
                        <a class="dropdown-item  " href="{{ route('corprofile.index') }}">
                        Our Company
                        </a>
                        <a class="dropdown-item" href="{{ route('bod.index') }}">
                        Board of Directors 
                        </a>    
                        <a class="dropdown-item" href="{{ route('ourtimeline.index') }}">
                        Time Line
                        </a>  
                        <a class="dropdown-item" href="{{ route('ourpartners.index') }}">
                        Partners
                        </a>                    
                      </div> 
                    </div>
                  </div>
                </li> 
                <li class="nav-item active dropdown">
                  <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/layout-2 -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M4 13m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /></svg>
                    </span>
                    <span class="nav-link-title">
                    Resource Center
                    </span>
                  </a>
                  <div class="dropdown-menu">
                    <div class="dropdown-menu-columns">
                      <div class="dropdown-menu-column">
                        <a class="dropdown-item active" href="{{ route('mediacategories.index') }}">
                        Media
                        </a>
                        <a class="dropdown-item" href="{{ route('downloadcategories.index') }}">
                        Downloads
                        </a>    
                        <!-- <a class="dropdown-item" href="{{ route('downloadcategories.index') }}}">
                        Sustainability
                        </a>                      -->
                      </div> 
                    </div>
                  </div>
                </li>  
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('vacancies.index') }}" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title">
                    Vacancies
                    </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('news.index') }}" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title">
                    News
                    </span>
                  </a>
                </li> 
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('hero-sections.index') }}" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title">
                    Hero Sections
                    </span>
                  </a>
                </li> 
                <li class="nav-item active dropdown">
                  <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/layout-2 -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M4 13m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /></svg>
                    </span>
                    <span class="nav-link-title">
                    Get in Touch
                    </span>
                  </a>
                  <div class="dropdown-menu">
                    <div class="dropdown-menu-columns">
                      <div class="dropdown-menu-column">
                        <a class="dropdown-item active" href="{{ route('locations.index') }}">
                        Location
                        </a>
                        <a class="dropdown-item" href="{{ route('places.index') }}">
                        Places
                        </a>                   
                      </div> 
                    </div>
                  </div>
                </li>  
              </ul> 
            </div>
          </div>
        </div>
      </header>










        <!-- Page Content -->
        <div class="page-wrapper">    
            @if (session('success'))
            <div class="alert alert-success alert-fade mt-4 cmsalert" role="alert">
                {{ session('success') }}
            </div>
            @endif
            @if (session('status'))
            <div class="alert alert-success alert-fade mt-4 cmsalert" role="alert">
                {{ session('status') }}
            </div>
            @endif
            @if ($errors->any())
            <ul class="alert alert-warning cmsalert">
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            @endif
            @error('permission')
            <div class="alert alert-warning alert-fade mt-4 cmsalert" role="alert">
                {{ $message }}
            </div>
            @enderror

            @yield('content') 
         
            <!-- Footer -->
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item"><a href="#" class="link-secondary">Documentation</a></li>
                                <li class="list-inline-item"><a href="#" class="link-secondary">Support</a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright © 2025 <a href="#" class="link-secondary">WAMCO CMS</a>. All rights reserved.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Scripts at the end of body for better performance -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
    
    <script> 
        // Alert auto-hide functionality
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.cmsalert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 2000);
            });
        });

        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            const html = document.documentElement;
            const currentTheme = localStorage.getItem('theme') || 'light';
            html.setAttribute('data-bs-theme', currentTheme);
            if (currentTheme === 'dark') {
                themeToggle.checked = true;
            }
            
            themeToggle.addEventListener('change', function() {
                if (this.checked) {
                    html.setAttribute('data-bs-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    html.setAttribute('data-bs-theme', 'light');
                    localStorage.setItem('theme', 'light');
                }
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>