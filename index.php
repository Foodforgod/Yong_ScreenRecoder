<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OmniCap - Web Screen Recorder & Video Studio</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            navy: {
              950: '#070a12',
              900: '#0b0f19',
              800: '#111827',
              700: '#1f293d',
              600: '#2d3b55'
            },
            brand: {
              purple: '#8b5cf6',
              indigo: '#6366f1',
              pink: '#ec4899',
              glow: 'rgba(139, 92, 246, 0.35)'
            }
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <style>
    /* Custom Styling for Glassmorphism & UI Effects */
    body {
      background-color: #070a12;
      background-image: 
        radial-gradient(at 10% 10%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
        radial-gradient(at 90% 90%, rgba(236, 72, 153, 0.12) 0px, transparent 50%),
        radial-gradient(at 50% 50%, rgba(139, 92, 246, 0.08) 0px, transparent 50%);
      background-attachment: fixed;
      font-family: 'Inter', sans-serif;
      color: #f3f4f6;
    }

    .glass-panel {
      background: rgba(17, 24, 39, 0.65);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .glass-card {
      background: rgba(31, 41, 61, 0.4);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.06);
    }

    .glass-modal {
      background: rgba(11, 15, 25, 0.85);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.12);
    }

    .btn-gradient {
      background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
      background-size: 200% 200%;
      transition: all 0.3s ease;
    }

    .btn-gradient:hover {
      background-position: right center;
      box-shadow: 0 0 20px rgba(139, 92, 246, 0.5);
    }

    .btn-recording {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
      animation: pulse-red 2s infinite;
    }

    @keyframes pulse-red {
      0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.6); }
      70% { box-shadow: 0 0 0 12px rgba(239, 68, 68, 0); }
      100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: rgba(11, 15, 25, 0.5);
    }
    ::-webkit-scrollbar-thumb {
      background: rgba(139, 92, 246, 0.3);
      border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: rgba(139, 92, 246, 0.6);
    }

    
input[type=range] {
  appearance: none;
  background: rgba(255, 255, 255, 0.1);
  height: 6px;
  border-radius: 3px;
}
    input[type=range]::-webkit-slider-thumb {
      -webkit-appearance: none;
      height: 16px;
      width: 16px;
      border-radius: 50%;
      background: #8b5cf6;
      cursor: pointer;
      box-shadow: 0 0 8px rgba(139, 92, 246, 0.8);
    }

    /* Overlay PIP Drag Handle */
    .pip-container {
      user-select: none;
      touch-action: none;
    }

    .pip-circle {
      border-radius: 50%;
      overflow: hidden;
    }

    .pip-rect {
      border-radius: 12px;
      overflow: hidden;
    }

    /* Recording Indicator pulse */
    .recording-dot {
      animation: blink 1s cubic-bezier(0.5, 0, 1, 1) infinite alternate;
    }
    @keyframes blink {
      0% { opacity: 1; }
      100% { opacity: 0.2; }
    }
  </style>
</head>
<body class="min-h-screen flex flex-col justify-between overflow-x-hidden text-slate-200">

  <!-- TOP HEADER NAVBAR -->
  <header class="glass-panel sticky top-0 z-30 px-4 lg:px-8 py-3.5 flex items-center justify-between border-b border-white/10">
    <div class="flex items-center space-x-3">
      <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-indigo-500/30">
        <i class="fa-solid font-bold fa-video text-white text-lg"></i>
      </div>
      <div>
        <h1 class="font-bold text-lg leading-tight bg-clip-text text-transparent bg-gradient-to-r from-white via-slate-200 to-purple-300">
          OmniCap Studio
        </h1>
        <p class="text-xs text-slate-400">Professional Screen & Video Capture</p>
      </div>
    </div>

    <!-- STATUS & TIMER BADGES -->
    <div class="flex items-center space-x-4">
      <!-- Status Badge -->
      <div id="statusBadge" class="flex items-center space-x-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-slate-800/80 border border-slate-700/60 text-slate-300">
        <span id="statusDot" class="w-2.5 h-2.5 rounded-full bg-slate-500"></span>
        <span id="statusText">Idle</span>
      </div>

      <!-- Live Stream Info -->
      <div class="hidden sm:flex items-center space-x-3 text-xs text-slate-400 bg-slate-900/40 px-3 py-1.5 rounded-lg border border-white/5">
        <div><i class="fa-solid fa-desktop text-indigo-400 mr-1.5"></i><span id="resDisplay">--x--</span></div>
        <div class="border-r border-white/10 h-3"></div>
        <div><i class="fa-solid fa-gauge-high text-purple-400 mr-1.5"></i><span id="fpsDisplay">-- FPS</span></div>
      </div>

      <!-- Timer -->
      <div class="flex items-center space-x-2 bg-slate-900/80 border border-slate-700/80 px-3.5 py-1.5 rounded-lg font-mono font-bold text-base text-purple-300 shadow-inner">
        <i class="fa-regular fa-clock text-slate-400 text-xs"></i>
        <span id="timerDisplay">00:00:00</span>
      </div>
    </div>

    <!-- TOP RIGHT ACTION BUTTONS -->
    <div class="flex items-center space-x-2">
      <button id="btnOpenLibrary" class="px-3.5 py-2 rounded-xl bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700 text-xs font-medium text-slate-200 transition flex items-center space-x-2">
        <i class="fa-solid fa-folder-closed text-indigo-400"></i>
        <span class="hidden md:inline">Library</span>
        <span id="libraryBadge" class="ml-1 px-1.5 py-0.5 text-[10px] bg-indigo-500/30 text-indigo-300 rounded-full font-bold">0</span>
      </button>

      <button id="btnOpenSettings" class="p-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700 text-slate-300 hover:text-white transition">
        <i class="fa-solid fa-gear text-sm"></i>
      </button>
    </div>
  </header>

  <!-- MAIN STUDIO DASHBOARD CONTAINER -->
  <main class="flex-1 max-w-7xl w-full mx-auto p-4 sm:p-6 lg:p-8 flex flex-col space-y-6">
    
    <!-- MAIN DISPLAY SCREEN PREVIEW AREA -->
    <div class="relative w-full aspect-video max-h-[68vh] rounded-2xl glass-panel overflow-hidden shadow-2xl flex items-center justify-center group border border-slate-700/50">
      
      <!-- Placeholder when stream is inactive -->
      <div id="previewPlaceholder" class="flex flex-col items-center justify-center text-center p-6 space-y-4">
        <div class="w-20 h-20 rounded-full bg-slate-800/80 border border-slate-700/80 flex items-center justify-center text-indigo-400 text-3xl shadow-inner group-hover:scale-105 transition-transform">
          <i class="fa-solid fa-display"></i>
        </div>
        <div class="max-w-md">
          <h3 class="text-lg font-semibold text-slate-200">No Screen Selected</h3>
          <p class="text-sm text-slate-400 mt-1">Select a screen or window source below to begin previewing and recording your video.</p>
        </div>
        <button id="btnSelectScreenMain" class="px-5 py-2.5 rounded-xl btn-gradient text-white text-sm font-medium flex items-center space-x-2 shadow-lg shadow-indigo-500/20">
          <i class="fa-solid fa-desktop"></i>
          <span>Select Screen Source</span>
        </button>
      </div>

      <!-- Live Video Canvas (For Studio Mode Composite Output Preview) -->
      <canvas id="studioCanvas" class="hidden w-full h-full object-contain bg-black"></canvas>

      <!-- Raw Display Video Stream (Hidden when in studio canvas mode) -->
      <video id="displayVideo" autoplay playsinline muted class="hidden w-full h-full object-contain bg-black"></video>

      <!-- DRAGGABLE WEBCAM OVERLAY (PIP) -->
      <div id="webcamPipContainer" class="hidden absolute top-6 right-6 z-20 pip-container cursor-move shadow-2xl border-2 border-indigo-500/80 group/pip transition-shadow">
        <video id="webcamVideo" autoplay playsinline muted class="w-full h-full object-cover transform scale-x-[-1]"></video>
        <!-- Overlay Drag Indicator Badge -->
        <div class="absolute inset-0 bg-indigo-900/20 opacity-0 group-hover/pip:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
          <i class="fa-solid fa-up-down-left-right text-white text-lg drop-shadow"></i>
        </div>
      </div>

      <!-- LIVE AUDIO VU METER OVERLAY -->
      <div id="vuMeterOverlay" class="hidden absolute bottom-4 left-4 z-10 glass-card px-3 py-2 rounded-xl border border-white/10 flex items-center space-x-2">
        <i class="fa-solid fa-microphone text-xs text-indigo-400"></i>
        <div class="w-24 h-2 bg-slate-800 rounded-full overflow-hidden border border-slate-700">
          <div id="vuMeterBar" class="h-full w-0 bg-gradient-to-r from-emerald-400 via-indigo-400 to-pink-500 transition-all duration-75"></div>
        </div>
      </div>

      <!-- STUDIO MODE WATERMARK BADGE -->
      <div id="studioBadge" class="hidden absolute top-4 left-4 z-10 glass-card px-3 py-1 rounded-full text-[11px] font-bold text-purple-300 border border-purple-500/30 flex items-center space-x-1.5">
        <span class="w-2 h-2 rounded-full bg-purple-400 animate-pulse"></span>
        <span>STUDIO COMPOSITOR ACTIVE</span>
      </div>
    </div>

    <!-- MAIN FLOATING CONTROL BAR -->
    <div class="glass-panel p-4 rounded-2xl border border-slate-700/60 shadow-xl flex flex-wrap items-center justify-between gap-4">
      
      <!-- Source Controls Group -->
      <div class="flex items-center space-x-2 sm:space-x-3">
        <!-- Select Screen Button -->
        <button id="btnSelectScreen" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-xs font-semibold text-slate-200 transition flex items-center space-x-2">
          <i class="fa-solid fa-desktop text-indigo-400"></i>
          <span class="hidden sm:inline">Source</span>
        </button>

        <!-- Webcam Toggle Button -->
        <button id="btnToggleWebcam" class="p-2.5 sm:px-4 sm:py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-xs font-semibold text-slate-300 transition flex items-center space-x-2">
          <i id="iconWebcam" class="fa-solid fa-camera text-slate-400"></i>
          <span class="hidden sm:inline">Webcam</span>
        </button>

        <!-- Mic Toggle Button -->
        <button id="btnToggleMic" class="p-2.5 sm:px-4 sm:py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-xs font-semibold text-slate-300 transition flex items-center space-x-2">
          <i id="iconMic" class="fa-solid fa-microphone-slash text-slate-400"></i>
          <span class="hidden sm:inline">Microphone</span>
        </button>

        <!-- Studio Mode Toggle -->
        <button id="btnToggleStudio" class="p-2.5 sm:px-4 sm:py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-xs font-semibold text-slate-300 transition flex items-center space-x-2" title="Burn webcam PIP into recorded video">
          <i class="fa-solid fa-wand-magic-sparkles text-purple-400"></i>
          <span class="hidden md:inline">Studio PIP</span>
        </button>
      </div>

      <!-- Recording Main Action Controls -->
      <div class="flex items-center space-x-3 mx-auto sm:mx-0">
        <!-- Start / Stop Recording Button -->
        <button id="btnStartRecord" disabled class="px-6 py-3 rounded-xl btn-gradient text-white text-sm font-bold shadow-lg flex items-center space-x-2 disabled:opacity-40 disabled:cursor-not-allowed">
          <i id="iconRecord" class="fa-solid fa-circle text-xs"></i>
          <span id="textRecord">Start Recording</span>
        </button>

        <!-- Pause / Resume Recording Button -->
        <button id="btnPauseRecord" class="hidden p-3 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-200 transition">
          <i id="iconPause" class="fa-solid fa-pause"></i>
        </button>
      </div>

      <!-- Quick Adjustments (Webcam PIP Settings) -->
      <div id="pipQuickSettings" class="hidden flex items-center space-x-3 text-xs bg-slate-900/60 p-2 rounded-xl border border-white/5">
        <div class="flex items-center space-x-1">
          <span class="text-slate-400">PIP:</span>
          <button id="btnPipShape" class="px-2 py-1 bg-slate-800 hover:bg-slate-700 rounded text-[11px] font-semibold text-indigo-300">Circle</button>
        </div>
        <div class="flex items-center space-x-1.5">
          <i class="fa-solid fa-expand text-slate-500 text-[10px]"></i>
          <input id="sliderPipSize" type="range" min="120" max="320" value="180" class="w-16">
        </div>
      </div>

    </div>

  </main>

  <!-- RECORDING PREVIEW & EXPORT MODAL -->
  <div id="modalExport" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
    <div class="glass-modal max-w-4xl w-full rounded-2xl border border-slate-700/80 shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
      
      <!-- Modal Header -->
      <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-8 h-8 rounded-lg bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400">
            <i class="fa-solid fa-check text-sm"></i>
          </div>
          <div>
            <h3 class="font-bold text-slate-100 text-base">Recording Ready</h3>
            <p class="text-xs text-slate-400">Preview, snapshot, or download your video capture</p>
          </div>
        </div>
        <button id="btnCloseExport" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">
          <i class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="p-6 overflow-y-auto space-y-6 flex-1">
        
        <!-- Video Player -->
        <div class="w-full aspect-video bg-black rounded-xl overflow-hidden border border-slate-800 shadow-inner">
          <video id="exportVideo" controls class="w-full h-full object-contain"></video>
        </div>

        <!-- Recording Details Meta Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
          <div class="glass-card p-3 rounded-xl border border-white/5">
            <span class="text-slate-400 block mb-0.5">Duration</span>
            <span id="metaDuration" class="font-semibold text-slate-200">00:00</span>
          </div>
          <div class="glass-card p-3 rounded-xl border border-white/5">
            <span class="text-slate-400 block mb-0.5">File Size</span>
            <span id="metaSize" class="font-semibold text-slate-200">0 MB</span>
          </div>
          <div class="glass-card p-3 rounded-xl border border-white/5">
            <span class="text-slate-400 block mb-0.5">Format / Codec</span>
            <span id="metaCodec" class="font-semibold text-indigo-300">video/webm</span>
          </div>
          <div class="glass-card p-3 rounded-xl border border-white/5">
            <span class="text-slate-400 block mb-0.5">Resolution</span>
            <span id="metaRes" class="font-semibold text-slate-200">1920x1080</span>
          </div>
        </div>

      </div>

      <!-- Modal Footer Action Buttons -->
      <div class="px-6 py-4 border-t border-slate-800 bg-slate-950/50 flex flex-wrap items-center justify-between gap-3">
        <button id="btnCaptureSnapshot" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-xs font-semibold text-slate-200 transition flex items-center space-x-2">
          <i class="fa-solid fa-camera text-purple-400"></i>
          <span>Capture PNG Snapshot</span>
        </button>

        <div class="flex items-center space-x-3">
          <button id="btnSaveToLibrary" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-xs font-semibold text-indigo-300 transition flex items-center space-x-2">
            <i class="fa-solid fa-bookmark text-indigo-400"></i>
            <span>Save to Library</span>
          </button>

          <button id="btnDownloadExport" class="px-5 py-2.5 rounded-xl btn-gradient text-white text-xs font-bold transition shadow-lg flex items-center space-x-2">
            <i class="fa-solid fa-download"></i>
            <span>Download Video</span>
          </button>
        </div>
      </div>

    </div>
  </div>

  <!-- RECORDINGS LIBRARY MODAL -->
  <div id="modalLibrary" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
    <div class="glass-modal max-w-5xl w-full rounded-2xl border border-slate-700/80 shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
      
      <!-- Modal Header -->
      <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-8 h-8 rounded-lg bg-indigo-500/20 border border-indigo-500/40 flex items-center justify-center text-indigo-400">
            <i class="fa-solid fa-folder-open text-sm"></i>
          </div>
          <div>
            <h3 class="font-bold text-slate-100 text-base">Recordings Library</h3>
            <p class="text-xs text-slate-400">Stored locally in your browser IndexedDB</p>
          </div>
        </div>
        <button id="btnCloseLibrary" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">
          <i class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>

      <!-- Library Grid List -->
      <div class="p-6 overflow-y-auto flex-1">
        <div id="libraryList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <!-- Dynamically populated card items -->
        </div>

        <!-- Empty state fallback -->
        <div id="libraryEmptyState" class="hidden flex flex-col items-center justify-center py-16 text-center space-y-3">
          <div class="w-16 h-16 rounded-full bg-slate-800/80 border border-slate-700/80 flex items-center justify-center text-slate-500 text-2xl">
            <i class="fa-solid fa-box-open"></i>
          </div>
          <p class="text-slate-300 font-semibold text-sm">No Saved Recordings</p>
          <p class="text-xs text-slate-500 max-w-xs">Your saved video recordings will appear here automatically.</p>
        </div>
      </div>

      <!-- Footer Info -->
      <div class="px-6 py-3 border-t border-slate-800 bg-slate-950/60 flex items-center justify-between text-xs text-slate-400">
        <span id="storageUsageInfo"><i class="fa-solid fa-database mr-1.5 text-indigo-400"></i>Storage: Loading...</span>
        <span>Stored strictly in local browser IndexedDB</span>
      </div>

    </div>
  </div>

  <!-- SETTINGS CONFIGURATION MODAL -->
  <div id="modalSettings" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
    <div class="glass-modal max-w-md w-full rounded-2xl border border-slate-700/80 shadow-2xl overflow-hidden flex flex-col">
      
      <!-- Modal Header -->
      <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <i class="fa-solid fa-sliders text-indigo-400 text-base"></i>
          <h3 class="font-bold text-slate-100 text-base">Recording Settings</h3>
        </div>
        <button id="btnCloseSettings" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">
          <i class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>

      <!-- Form Settings -->
      <div class="p-6 space-y-4 text-xs">
        
        <!-- Video Resolution -->
        <div>
          <label class="block text-slate-300 font-medium mb-1.5">Target Resolution</label>
          <select id="settingRes" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-slate-200 focus:outline-none focus:border-indigo-500">
            <option value="1080p" selected>1080p Full HD (1920x1080)</option>
            <option value="720p">720p HD (1280x720)</option>
            <option value="1440p">1440p 2K (2560x1440)</option>
            <option value="4k">4K Ultra HD (3840x2160)</option>
          </select>
        </div>

        <!-- Target Frame Rate -->
        <div>
          <label class="block text-slate-300 font-medium mb-1.5">Frame Rate (FPS)</label>
          <select id="settingFps" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-slate-200 focus:outline-none focus:border-indigo-500">
            <option value="30" selected>30 FPS (Standard)</option>
            <option value="60">60 FPS (High Smoothness)</option>
          </select>
        </div>

        <!-- Video Bitrate -->
        <div>
          <label class="block text-slate-300 font-medium mb-1.5">Video Bitrate</label>
          <select id="settingBitrate" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-slate-200 focus:outline-none focus:border-indigo-500">
            <option value="2500000">2.5 Mbps (Low File Size)</option>
            <option value="5000000" selected>5.0 Mbps (Recommended Standard)</option>
            <option value="8000000">8.0 Mbps (High Quality)</option>
            <option value="15000000">15.0 Mbps (Ultra Quality)</option>
          </select>
        </div>

        <!-- Audio Toggles -->
        <div class="space-y-2.5 pt-2 border-t border-slate-800">
          <label class="flex items-center justify-between cursor-pointer">
            <span class="text-slate-300 font-medium">Echo Cancellation</span>
            <input id="settingEcho" type="checkbox" checked class="w-4 h-4 text-indigo-600 rounded bg-slate-900 border-slate-700 focus:ring-indigo-500">
          </label>
          <label class="flex items-center justify-between cursor-pointer">
            <span class="text-slate-300 font-medium">Noise Suppression</span>
            <input id="settingNoise" type="checkbox" checked class="w-4 h-4 text-indigo-600 rounded bg-slate-900 border-slate-700 focus:ring-indigo-500">
          </label>
        </div>

        <!-- Default Filename -->
        <div class="pt-2 border-t border-slate-800">
          <label class="block text-slate-300 font-medium mb-1.5">Default Filename Prefix</label>
          <input id="settingFilename" type="text" value="OmniCap_Recording" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-slate-200 focus:outline-none focus:border-indigo-500">
        </div>

      </div>

      <div class="px-6 py-4 border-t border-slate-800 bg-slate-950/50 flex justify-end">
        <button id="btnSaveSettings" class="px-5 py-2 rounded-xl btn-gradient text-white text-xs font-bold">
          Save Preferences
        </button>
      </div>

    </div>
  </div>

  <!-- TOAST NOTIFICATION CONTAINER -->
  <div id="toastContainer" class="fixed bottom-6 right-6 z-50 flex flex-col space-y-2 pointer-events-none"></div>

  <!-- FOOTER -->
  <footer class="glass-panel py-3 px-6 text-center text-xs text-slate-400 border-t border-white/5">
    <span>OmniCap Video Studio &bull; Private, client-side screen recording software</span>
  </footer>

  <!-- MAIN APPLICATION JAVASCRIPT LOGIC -->
  <script type="module">
    // ==========================================
    // 1. INDEXEDDB LOCAL STORAGE MANAGER
    // ==========================================
    class DBStorage {
      constructor() {
        this.dbName = 'ScreenRecorderDB';
        this.version = 1;
        this.db = null;
      }

      async init() {
        return new Promise((resolve, reject) => {
          const request = indexedDB.open(this.dbName, this.version);
          request.onerror = () => reject('Failed to open IndexedDB');
          request.onsuccess = (e) => {
            this.db = e.target.result;
            resolve();
          };
          request.onupgradeneeded = (e) => {
            const db = e.target.result;
            if (!db.objectStoreNames.contains('recordings')) {
              const store = db.createObjectStore('recordings', { keyPath: 'id', autoIncrement: true });
              store.createIndex('createdAt', 'createdAt', { unique: false });
            }
          };
        });
      }

      async saveRecording(record) {
        return new Promise((resolve, reject) => {
          const tx = this.db.transaction('recordings', 'readwrite');
          const store = tx.objectStore('recordings');
          const request = store.add(record);
          request.onsuccess = () => resolve(request.result);
          request.onerror = () => reject('Failed to save recording to DB');
        });
      }

      async getAllRecordings() {
        return new Promise((resolve, reject) => {
          const tx = this.db.transaction('recordings', 'readonly');
          const store = tx.objectStore('recordings');
          const index = store.index('createdAt');
          const request = index.openCursor(null, 'prev'); // Latest first
          const results = [];
          request.onsuccess = (e) => {
            const cursor = e.target.result;
            if (cursor) {
              results.push(cursor.value);
              cursor.continue();
            } else {
              resolve(results);
            }
          };
          request.onerror = () => reject('Failed to fetch recordings');
        });
      }

      async renameRecording(id, newTitle) {
        return new Promise((resolve, reject) => {
          const tx = this.db.transaction('recordings', 'readwrite');
          const store = tx.objectStore('recordings');
          const getReq = store.get(id);
          getReq.onsuccess = () => {
            const data = getReq.result;
            if (data) {
              data.title = newTitle;
              store.put(data).onsuccess = () => resolve();
            }
          };
          getReq.onerror = () => reject('Failed to rename recording');
        });
      }

      async deleteRecording(id) {
        return new Promise((resolve, reject) => {
          const tx = this.db.transaction('recordings', 'readwrite');
          const store = tx.objectStore('recordings');
          const req = store.delete(id);
          req.onsuccess = () => resolve();
          req.onerror = () => reject('Failed to delete recording');
        });
      }

      async getStorageUsage() {
        if (navigator.storage && navigator.storage.estimate) {
          const estimate = await navigator.storage.estimate();
          return {
            used: (estimate.usage / (1024 * 1024)).toFixed(1),
            quota: (estimate.quota / (1024 * 1024 * 1024)).toFixed(1)
          };
        }
        return { used: 'N/A', quota: 'N/A' };
      }
    }

    // ==========================================
    // 2. WEB AUDIO MIXER & VISUALIZER
    // ==========================================
    class AudioMixer {
      constructor() {
        this.audioCtx = null;
        this.destNode = null;
        this.micSource = null;
        this.sysSource = null;
        this.analyser = null;
      }

      init() {
        if (!this.audioCtx) {
          const AudioContextClass = window.AudioContext || window.webkitAudioContext;
          this.audioCtx = new AudioContextClass();
          this.destNode = this.audioCtx.createMediaStreamDestination();
        }
        if (this.audioCtx.state === 'suspended') {
          this.audioCtx.resume();
        }
      }

      setupMicrophone(micStream, volume = 1.0) {
        this.init();
        if (this.micSource) {
          try { this.micSource.disconnect(); } catch(e) {}
        }
        if (micStream && micStream.getAudioTracks().length > 0) {
          this.micSource = this.audioCtx.createMediaStreamSource(micStream);
          const gainNode = this.audioCtx.createGain();
          gainNode.gain.value = volume;

          // Visualizer Analyser Setup
          this.analyser = this.audioCtx.createAnalyser();
          this.analyser.fftSize = 64;

          this.micSource.connect(gainNode);
          gainNode.connect(this.analyser);
          gainNode.connect(this.destNode);
        }
      }

      setupSystemAudio(sysStream) {
        this.init();
        if (this.sysSource) {
          try { this.sysSource.disconnect(); } catch(e) {}
        }
        if (sysStream && sysStream.getAudioTracks().length > 0) {
          this.sysSource = this.audioCtx.createMediaStreamSource(sysStream);
          const gainNode = this.audioCtx.createGain();
          gainNode.gain.value = 1.0;
          this.sysSource.connect(gainNode);
          gainNode.connect(this.destNode);
        }
      }

      getMixedAudioTrack() {
        if (this.destNode && this.destNode.stream.getAudioTracks().length > 0) {
          return this.destNode.stream.getAudioTracks()[0];
        }
        return null;
      }

      getMicLevel() {
        if (!this.analyser) return 0;
        const dataArray = new Uint8Array(this.analyser.frequencyBinCount);
        this.analyser.getByteFrequencyData(dataArray);
        let sum = 0;
        for (let i = 0; i < dataArray.length; i++) {
          sum += dataArray[i];
        }
        return sum / dataArray.length;
      }

      cleanup() {
        if (this.audioCtx && this.audioCtx.state !== 'closed') {
          this.audioCtx.close();
          this.audioCtx = null;
        }
        this.micSource = null;
        this.sysSource = null;
        this.destNode = null;
        this.analyser = null;
      }
    }

    // ==========================================
    // 3. CANVAS STUDIO COMPOSITOR ENGINE
    // ==========================================
    class StudioCompositor {
      constructor(canvas, displayVideo, webcamVideo) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.displayVideo = displayVideo;
        this.webcamVideo = webcamVideo;
        this.isCompositing = false;
        this.animFrameId = null;

        // PIP Settings
        this.pipShape = 'circle'; // 'circle' or 'rect'
        this.pipSize = 180;
        this.pipX = 0.8; // Ratio relative to width
        this.pipY = 0.05; // Ratio relative to height
      }

      start() {
        this.isCompositing = true;
        this.canvas.width = this.displayVideo.videoWidth || 1920;
        this.canvas.height = this.displayVideo.videoHeight || 1080;
        this.renderLoop();
      }

      stop() {
        this.isCompositing = false;
        if (this.animFrameId) {
          cancelAnimationFrame(this.animFrameId);
          this.animFrameId = null;
        }
      }

      renderLoop() {
        if (!this.isCompositing) return;

        // Match resolution dynamically if screen res changes
        if (this.displayVideo.videoWidth && this.canvas.width !== this.displayVideo.videoWidth) {
          this.canvas.width = this.displayVideo.videoWidth;
          this.canvas.height = this.displayVideo.videoHeight;
        }

        const width = this.canvas.width;
        const height = this.canvas.height;

        // Clear canvas
        this.ctx.clearRect(0, 0, width, height);

        // Draw screen video frame
        if (this.displayVideo.readyState >= 2) {
          this.ctx.drawImage(this.displayVideo, 0, 0, width, height);
        }

        // Draw Webcam PIP overlay if active
        if (this.webcamVideo && this.webcamVideo.readyState >= 2 && !this.webcamVideo.paused) {
          const pipW = this.pipSize;
          const pipH = (this.pipShape === 'circle') ? this.pipSize : Math.round(this.pipSize * 0.75);
          const posX = width * this.pipX;
          const posY = height * this.pipY;

          this.ctx.save();
          this.ctx.beginPath();

          if (this.pipShape === 'circle') {
            const radius = pipW / 2;
            this.ctx.arc(posX + radius, posY + radius, radius, 0, Math.PI * 2);
          } else {
            this.ctx.roundRect(posX, posY, pipW, pipH, 12);
          }

          this.ctx.clip();

          // Mirror webcam horizontally inside composite
          this.ctx.translate(posX + pipW, posY);
          this.ctx.scale(-1, 1);
          this.ctx.drawImage(this.webcamVideo, 0, 0, pipW, pipH);
          this.ctx.restore();

          // Draw PIP Border
          this.ctx.save();
          this.ctx.beginPath();
          if (this.pipShape === 'circle') {
            const radius = pipW / 2;
            this.ctx.arc(posX + radius, posY + radius, radius, 0, Math.PI * 2);
          } else {
            this.ctx.roundRect(posX, posY, pipW, pipH, 12);
          }
          this.ctx.strokeStyle = '#8b5cf6';
          this.ctx.lineWidth = 4;
          this.ctx.stroke();
          this.ctx.restore();
        }

        this.animFrameId = requestAnimationFrame(() => this.renderLoop());
      }

      getCapturedStream(fps = 60) {
        return this.canvas.captureStream(fps);
      }
    }

    // ==========================================
    // 4. MAIN APP APPLICATION CONTROLLER
    // ==========================================
    class ScreenRecorderApp {
      constructor() {
        this.db = new DBStorage();
        this.audioMixer = new AudioMixer();
        
        // Media Streams
        this.screenStream = null;
        this.webcamStream = null;
        this.micStream = null;
        this.recordedChunks = [];
        this.mediaRecorder = null;
        this.currentBlob = null;

        // State Flags
        this.recordingState = 'idle'; // idle, recording, paused
        this.isStudioMode = false;
        this.timerInterval = null;
        this.startTime = 0;
        this.elapsedPausedTime = 0;
        this.pauseStartTime = 0;

        // Settings Defaults
        this.settings = {
          res: '1080p',
          fps: 30,
          bitrate: 5000000,
          echo: true,
          noise: true,
          filename: 'OmniCap_Recording'
        };

        // DOM Elements
        this.bindElements();
        this.compositor = new StudioCompositor(this.dom.studioCanvas, this.dom.displayVideo, this.dom.webcamVideo);
      }

      bindElements() {
        this.dom = {
          // Status Badges
          statusDot: document.getElementById('statusDot'),
          statusText: document.getElementById('statusText'),
          resDisplay: document.getElementById('resDisplay'),
          fpsDisplay: document.getElementById('fpsDisplay'),
          timerDisplay: document.getElementById('timerDisplay'),
          libraryBadge: document.getElementById('libraryBadge'),
          vuMeterBar: document.getElementById('vuMeterBar'),
          vuMeterOverlay: document.getElementById('vuMeterOverlay'),
          studioBadge: document.getElementById('studioBadge'),

          // Displays & Canvas
          previewPlaceholder: document.getElementById('previewPlaceholder'),
          displayVideo: document.getElementById('displayVideo'),
          studioCanvas: document.getElementById('studioCanvas'),
          webcamVideo: document.getElementById('webcamVideo'),
          webcamPipContainer: document.getElementById('webcamPipContainer'),

          // Main Controls
          btnSelectScreenMain: document.getElementById('btnSelectScreenMain'),
          btnSelectScreen: document.getElementById('btnSelectScreen'),
          btnToggleWebcam: document.getElementById('btnToggleWebcam'),
          btnToggleMic: document.getElementById('btnToggleMic'),
          btnToggleStudio: document.getElementById('btnToggleStudio'),
          btnStartRecord: document.getElementById('btnStartRecord'),
          btnPauseRecord: document.getElementById('btnPauseRecord'),
          iconRecord: document.getElementById('iconRecord'),
          textRecord: document.getElementById('textRecord'),
          iconPause: document.getElementById('iconPause'),
          iconMic: document.getElementById('iconMic'),
          iconWebcam: document.getElementById('iconWebcam'),

          // Quick PIP Controls
          pipQuickSettings: document.getElementById('pipQuickSettings'),
          btnPipShape: document.getElementById('btnPipShape'),
          sliderPipSize: document.getElementById('sliderPipSize'),

          // Modals & Modals Buttons
          btnOpenLibrary: document.getElementById('btnOpenLibrary'),
          btnOpenSettings: document.getElementById('btnOpenSettings'),
          modalExport: document.getElementById('modalExport'),
          modalLibrary: document.getElementById('modalLibrary'),
          modalSettings: document.getElementById('modalSettings'),
          btnCloseExport: document.getElementById('btnCloseExport'),
          btnCloseLibrary: document.getElementById('btnCloseLibrary'),
          btnCloseSettings: document.getElementById('btnCloseSettings'),

          // Export Modal Inner Elements
          exportVideo: document.getElementById('exportVideo'),
          metaDuration: document.getElementById('metaDuration'),
          metaSize: document.getElementById('metaSize'),
          metaCodec: document.getElementById('metaCodec'),
          metaRes: document.getElementById('metaRes'),
          btnCaptureSnapshot: document.getElementById('btnCaptureSnapshot'),
          btnSaveToLibrary: document.getElementById('btnSaveToLibrary'),
          btnDownloadExport: document.getElementById('btnDownloadExport'),

          // Library Inner Elements
          libraryList: document.getElementById('libraryList'),
          libraryEmptyState: document.getElementById('libraryEmptyState'),
          storageUsageInfo: document.getElementById('storageUsageInfo'),

          // Settings Form Controls
          settingRes: document.getElementById('settingRes'),
          settingFps: document.getElementById('settingFps'),
          settingBitrate: document.getElementById('settingBitrate'),
          settingEcho: document.getElementById('settingEcho'),
          settingNoise: document.getElementById('settingNoise'),
          settingFilename: document.getElementById('settingFilename'),
          btnSaveSettings: document.getElementById('btnSaveSettings'),

          // Toast Container
          toastContainer: document.getElementById('toastContainer')
        };
      }

      async init() {
        try {
          await this.db.init();
          this.updateLibraryBadge();
        } catch(e) {
          this.showToast('Could not initialize local storage database', 'error');
        }

        this.attachEventListeners();
        this.setupPipDrag();
        this.startVuMeterLoop();
      }

      attachEventListeners() {
        // Screen capture selection
        this.dom.btnSelectScreenMain.addEventListener('click', () => this.requestScreenCapture());
        this.dom.btnSelectScreen.addEventListener('click', () => this.requestScreenCapture());

        // Toggle Buttons
        this.dom.btnToggleWebcam.addEventListener('click', () => this.toggleWebcam());
        this.dom.btnToggleMic.addEventListener('click', () => this.toggleMicrophone());
        this.dom.btnToggleStudio.addEventListener('click', () => this.toggleStudioMode());

        // Recording Actions
        this.dom.btnStartRecord.addEventListener('click', () => this.handleRecordButtonClick());
        this.dom.btnPauseRecord.addEventListener('click', () => this.togglePauseRecording());

        // PIP Customization Controls
        this.dom.btnPipShape.addEventListener('click', () => {
          this.compositor.pipShape = (this.compositor.pipShape === 'circle') ? 'rect' : 'circle';
          this.dom.btnPipShape.textContent = (this.compositor.pipShape === 'circle') ? 'Circle' : 'Rectangle';
          if (this.compositor.pipShape === 'circle') {
            this.dom.webcamPipContainer.classList.remove('pip-rect');
            this.dom.webcamPipContainer.classList.add('pip-circle');
            this.dom.webcamPipContainer.style.height = `${this.compositor.pipSize}px`;
          } else {
            this.dom.webcamPipContainer.classList.remove('pip-circle');
            this.dom.webcamPipContainer.classList.add('pip-rect');
            this.dom.webcamPipContainer.style.height = `${Math.round(this.compositor.pipSize * 0.75)}px`;
          }
        });

        this.dom.sliderPipSize.addEventListener('input', (e) => {
          const val = parseInt(e.target.value);
          this.compositor.pipSize = val;
          this.dom.webcamPipContainer.style.width = `${val}px`;
          if (this.compositor.pipShape === 'circle') {
            this.dom.webcamPipContainer.style.height = `${val}px`;
          } else {
            this.dom.webcamPipContainer.style.height = `${Math.round(val * 0.75)}px`;
          }
        });

        // Modals Open/Close
        this.dom.btnOpenLibrary.addEventListener('click', () => this.openLibraryModal());
        this.dom.btnCloseLibrary.addEventListener('click', () => this.dom.modalLibrary.classList.add('hidden'));

        this.dom.btnOpenSettings.addEventListener('click', () => this.dom.modalSettings.classList.remove('hidden'));
        this.dom.btnCloseSettings.addEventListener('click', () => this.dom.modalSettings.classList.add('hidden'));

        this.dom.btnCloseExport.addEventListener('click', () => this.dom.modalExport.classList.add('hidden'));

        // Settings Save
        this.dom.btnSaveSettings.addEventListener('click', () => {
          this.settings.res = this.dom.settingRes.value;
          this.settings.fps = parseInt(this.dom.settingFps.value);
          this.settings.bitrate = parseInt(this.dom.settingBitrate.value);
          this.settings.echo = this.dom.settingEcho.checked;
          this.settings.noise = this.dom.settingNoise.checked;
          this.settings.filename = this.dom.settingFilename.value || 'OmniCap_Recording';
          this.dom.modalSettings.classList.add('hidden');
          this.showToast('Preferences saved successfully', 'success');
        });

        // Export Modal Actions
        this.dom.btnDownloadExport.addEventListener('click', () => this.downloadCurrentRecording());
        this.dom.btnCaptureSnapshot.addEventListener('click', () => this.captureSnapshot());
        this.dom.btnSaveToLibrary.addEventListener('click', () => this.saveCurrentToLibrary());
      }

      // ==========================================
      // SCREEN & MEDIA CAPTURE LOGIC
      // ==========================================
      async requestScreenCapture() {
        try {
          const targetRes = this.getResolutionDimensions(this.settings.res);
          this.screenStream = await navigator.mediaDevices.getDisplayMedia({
            video: {
              width: { ideal: targetRes.width },
              height: { ideal: targetRes.height },
              frameRate: { ideal: this.settings.fps }
            },
            audio: true
          });

          // Set display video source
          this.dom.displayVideo.srcObject = this.screenStream;
          this.dom.previewPlaceholder.classList.add('hidden');

          if (this.isStudioMode) {
            this.dom.studioCanvas.classList.remove('hidden');
            this.dom.displayVideo.classList.add('hidden');
            this.compositor.start();
          } else {
            this.dom.displayVideo.classList.remove('hidden');
            this.dom.studioCanvas.classList.add('hidden');
          }

          // Handle when user clicks browser native "Stop Sharing" button
          const videoTrack = this.screenStream.getVideoTracks()[0];
          videoTrack.onended = () => this.handleScreenStreamEnded();

          // Setup System Audio if included
          this.audioMixer.setupSystemAudio(this.screenStream);

          // Update Info Overlay
          const settings = videoTrack.getSettings();
          this.dom.resDisplay.textContent = `${settings.width || 1920}x${settings.height || 1080}`;
          this.dom.fpsDisplay.textContent = `${Math.round(settings.frameRate || 30)} FPS`;

          this.dom.btnStartRecord.disabled = false;
          this.showToast('Screen capture stream connected', 'info');

        } catch (err) {
          console.error(err);
          this.showToast('Screen capture permission denied or cancelled', 'warning');
        }
      }

      handleScreenStreamEnded() {
        if (this.recordingState !== 'idle') {
          this.stopRecording();
        }
        this.screenStream = null;
        this.dom.displayVideo.srcObject = null;
        this.dom.displayVideo.classList.add('hidden');
        this.dom.studioCanvas.classList.add('hidden');
        this.dom.previewPlaceholder.classList.remove('hidden');
        this.dom.btnStartRecord.disabled = true;
        this.dom.resDisplay.textContent = '--x--';
        this.dom.fpsDisplay.textContent = '-- FPS';
        this.compositor.stop();
        this.showToast('Screen capture ended', 'info');
      }

      async toggleWebcam() {
        if (this.webcamStream) {
          // Disable webcam
          this.webcamStream.getTracks().forEach(t => t.stop());
          this.webcamStream = null;
          this.dom.webcamVideo.srcObject = null;
          this.dom.webcamPipContainer.classList.add('hidden');
          this.dom.pipQuickSettings.classList.add('hidden');
          this.dom.btnToggleWebcam.classList.remove('bg-purple-600/30', 'border-purple-500');
          this.dom.iconWebcam.className = 'fa-solid fa-camera text-slate-400';
          this.showToast('Webcam turned off', 'info');
        } else {
          // Enable webcam
          try {
            this.webcamStream = await navigator.mediaDevices.getUserMedia({
              video: { width: { ideal: 640 }, height: { ideal: 480 } },
              audio: false
            });
            this.dom.webcamVideo.srcObject = this.webcamStream;
            this.dom.webcamPipContainer.classList.remove('hidden');
            this.dom.pipQuickSettings.classList.remove('hidden');
            this.dom.btnToggleWebcam.classList.add('bg-purple-600/30', 'border-purple-500');
            this.dom.iconWebcam.className = 'fa-solid fa-camera text-purple-400';

            // Initial size setup
            const size = this.compositor.pipSize;
            this.dom.webcamPipContainer.style.width = `${size}px`;
            this.dom.webcamPipContainer.style.height = `${size}px`;
            this.dom.webcamPipContainer.classList.add('pip-circle');

            this.showToast('Webcam overlay enabled', 'info');
          } catch (err) {
            this.showToast('Could not access webcam device', 'error');
          }
        }
      }

      async toggleMicrophone() {
        if (this.micStream) {
          // Disable mic
          this.micStream.getTracks().forEach(t => t.stop());
          this.micStream = null;
          this.audioMixer.setupMicrophone(null);
          this.dom.vuMeterOverlay.classList.add('hidden');
          this.dom.btnToggleMic.classList.remove('bg-indigo-600/30', 'border-indigo-500');
          this.dom.iconMic.className = 'fa-solid fa-microphone-slash text-slate-400';
          this.showToast('Microphone muted', 'info');
        } else {
          // Enable mic
          try {
            this.micStream = await navigator.mediaDevices.getUserMedia({
              audio: {
                echoCancellation: this.settings.echo,
                noiseSuppression: this.settings.noise
              },
              video: false
            });
            this.audioMixer.setupMicrophone(this.micStream);
            this.dom.vuMeterOverlay.classList.remove('hidden');
            this.dom.btnToggleMic.classList.add('bg-indigo-600/30', 'border-indigo-500');
            this.dom.iconMic.className = 'fa-solid fa-microphone text-indigo-400';
            this.showToast('Microphone activated', 'info');
          } catch(err) {
            this.showToast('Could not access microphone', 'error');
          }
        }
      }

      toggleStudioMode() {
        this.isStudioMode = !this.isStudioMode;
        if (this.isStudioMode) {
          this.dom.btnToggleStudio.classList.add('bg-purple-600/30', 'border-purple-500');
          this.dom.studioBadge.classList.remove('hidden');
          if (this.screenStream) {
            this.dom.displayVideo.classList.add('hidden');
            this.dom.studioCanvas.classList.remove('hidden');
            this.compositor.start();
          }
          this.showToast('Studio Compositor Mode ON (Webcam PIP burned into output)', 'info');
        } else {
          this.dom.btnToggleStudio.classList.remove('bg-purple-600/30', 'border-purple-500');
          this.dom.studioBadge.classList.add('hidden');
          this.compositor.stop();
          if (this.screenStream) {
            this.dom.studioCanvas.classList.add('hidden');
            this.dom.displayVideo.classList.remove('hidden');
          }
          this.showToast('Standard Screen Capture Mode active', 'info');
        }
      }

      // ==========================================
      // RECORDING LIFECYCLE ENGINE
      // ==========================================
      handleRecordButtonClick() {
        if (this.recordingState === 'idle') {
          this.startRecording();
        } else {
          this.stopRecording();
        }
      }

      startRecording() {
        if (!this.screenStream) {
          this.showToast('Please select a screen source first', 'warning');
          return;
        }

        this.recordedChunks = [];

        // Determine final Video Source Track (Studio Composite vs Raw Display)
        let videoTrack = null;
        if (this.isStudioMode) {
          const compStream = this.compositor.getCapturedStream(this.settings.fps);
          videoTrack = compStream.getVideoTracks()[0];
        } else {
          videoTrack = this.screenStream.getVideoTracks()[0];
        }

        // Construct MediaStream for recorder
        const combinedStream = new MediaStream();
        combinedStream.addTrack(videoTrack);

        // Mixed Audio Track from Web Audio API
        const mixedAudioTrack = this.audioMixer.getMixedAudioTrack();
        if (mixedAudioTrack) {
          combinedStream.addTrack(mixedAudioTrack);
        } else if (this.screenStream.getAudioTracks().length > 0) {
          combinedStream.addTrack(this.screenStream.getAudioTracks()[0]);
        }

        // Determine Supported MIME Type
        const mimeType = this.getBestSupportedMimeType();

        try {
          this.mediaRecorder = new MediaRecorder(combinedStream, {
            mimeType: mimeType,
            videoBitsPerSecond: this.settings.bitrate
          });
        } catch (err) {
          console.error('MediaRecorder initialization error:', err);
          this.showToast('Failed to initialize recorder with selected settings', 'error');
          return;
        }

        this.mediaRecorder.ondataavailable = (e) => {
          if (e.data && e.data.size > 0) {
            this.recordedChunks.push(e.data);
          }
        };

        this.mediaRecorder.onstop = () => this.handleRecordingStop(mimeType);

        this.mediaRecorder.start(1000); // 1 sec timeslices
        this.recordingState = 'recording';

        // Update UI
        this.dom.btnStartRecord.className = 'px-6 py-3 rounded-xl btn-recording text-white text-sm font-bold shadow-lg flex items-center space-x-2';
        this.dom.iconRecord.className = 'fa-solid fa-square text-xs';
        this.dom.textRecord.textContent = 'Stop Recording';
        this.dom.btnPauseRecord.classList.remove('hidden');

        this.updateStatus('Recording', 'bg-red-500');

        // Start Timer
        this.startTime = Date.now();
        this.elapsedPausedTime = 0;
        this.timerInterval = setInterval(() => this.updateTimer(), 1000);

        this.showToast('Recording started', 'success');
      }

      togglePauseRecording() {
        if (this.recordingState === 'recording') {
          this.mediaRecorder.pause();
          this.recordingState = 'paused';
          this.pauseStartTime = Date.now();
          this.dom.iconPause.className = 'fa-solid fa-play text-emerald-400';
          this.updateStatus('Paused', 'bg-amber-500');
          this.showToast('Recording paused', 'warning');
        } else if (this.recordingState === 'paused') {
          this.mediaRecorder.resume();
          this.recordingState = 'recording';
          this.elapsedPausedTime += (Date.now() - this.pauseStartTime);
          this.dom.iconPause.className = 'fa-solid fa-pause';
          this.updateStatus('Recording', 'bg-red-500');
          this.showToast('Recording resumed', 'info');
        }
      }

      stopRecording() {
        if (this.mediaRecorder && this.recordingState !== 'idle') {
          this.mediaRecorder.stop();
        }
      }

      handleRecordingStop(mimeType) {
        clearInterval(this.timerInterval);
        this.recordingState = 'idle';

        // Reset UI Buttons
        this.dom.btnStartRecord.className = 'px-6 py-3 rounded-xl btn-gradient text-white text-sm font-bold shadow-lg flex items-center space-x-2';
        this.dom.iconRecord.className = 'fa-solid fa-circle text-xs';
        this.dom.textRecord.textContent = 'Start Recording';
        this.dom.btnPauseRecord.classList.add('hidden');
        this.dom.iconPause.className = 'fa-solid fa-pause';

        this.updateStatus('Ready', 'bg-emerald-500');

        // Create Blob
        this.currentBlob = new Blob(this.recordedChunks, { type: mimeType });
        const videoUrl = URL.createObjectURL(this.currentBlob);

        // Populate Export Modal
        this.dom.exportVideo.src = videoUrl;
        this.dom.metaDuration.textContent = this.dom.timerDisplay.textContent;
        this.dom.metaSize.textContent = `${(this.currentBlob.size / (1024 * 1024)).toFixed(2)} MB`;
        this.dom.metaCodec.textContent = mimeType;
        this.dom.metaRes.textContent = this.dom.resDisplay.textContent;

        this.dom.modalExport.classList.remove('hidden');
        this.showToast('Recording completed!', 'success');
      }

      // ==========================================
      // EXPORT & DOWNLOAD ACTIONS
      // ==========================================
      downloadCurrentRecording() {
        if (!this.currentBlob) return;
        const ext = this.getFileExtension(this.currentBlob.type);
        const filename = `${this.settings.filename}_${this.getTimestamp()}.${ext}`;
        const a = document.createElement('a');
        a.href = URL.createObjectURL(this.currentBlob);
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        this.showToast('Downloading video file...', 'info');
      }

      captureSnapshot() {
        const video = this.dom.exportVideo;
        if (!video.videoWidth) {
          this.showToast('Video preview not ready for snapshot', 'warning');
          return;
        }

        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataUrl = canvas.toDataURL('image/png');
        const a = document.createElement('a');
        a.href = dataUrl;
        a.download = `Snapshot_${this.getTimestamp()}.png`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);

        this.showToast('PNG Snapshot captured and downloaded', 'success');
      }

      async saveCurrentToLibrary() {
        if (!this.currentBlob) return;
        const title = prompt('Enter a title for this recording:', `Recording ${new Date().toLocaleTimeString()}`);
        if (!title) return;

        // Generate Thumbnail
        const thumbnail = await this.generateThumbnail(this.dom.exportVideo);

        const record = {
          title: title,
          blob: this.currentBlob,
          duration: this.dom.metaDuration.textContent,
          size: (this.currentBlob.size / (1024 * 1024)).toFixed(2) + ' MB',
          type: this.currentBlob.type,
          thumbnail: thumbnail,
          createdAt: new Date().toISOString()
        };

        try {
          await this.db.saveRecording(record);
          this.updateLibraryBadge();
          this.showToast('Saved to local library', 'success');
          this.dom.modalExport.classList.add('hidden');
        } catch(e) {
          this.showToast('Error saving video to IndexedDB', 'error');
        }
      }

      // ==========================================
      // LIBRARY MODAL MANAGEMENT
      // ==========================================
      async openLibraryModal() {
        this.dom.modalLibrary.classList.remove('hidden');
        await this.renderLibraryItems();

        const usage = await this.db.getStorageUsage();
        this.dom.storageUsageInfo.innerHTML = `<i class="fa-solid fa-database mr-1.5 text-indigo-400"></i>Storage Used: ${usage.used} MB / Quota: ${usage.quota} GB`;
      }

      async renderLibraryItems() {
        const items = await this.db.getAllRecordings();
        this.dom.libraryList.innerHTML = '';

        if (items.length === 0) {
          this.dom.libraryEmptyState.classList.remove('hidden');
          return;
        }

        this.dom.libraryEmptyState.classList.add('hidden');

        items.forEach((item) => {
          const card = document.createElement('div');
          card.className = 'glass-card rounded-xl border border-slate-800 overflow-hidden flex flex-col group';
          
          const videoUrl = URL.createObjectURL(item.blob);

          card.innerHTML = `
            <div class="relative w-full aspect-video bg-black overflow-hidden flex items-center justify-center">
              ${item.thumbnail 
                ? `<img src="${item.thumbnail}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">`
                : `<div class="text-slate-600"><i class="fa-solid fa-film text-3xl"></i></div>`
              }
              <div class="absolute bottom-2 right-2 bg-black/70 px-2 py-0.5 rounded text-[10px] font-mono text-purple-300">${item.duration}</div>
            </div>
            <div class="p-3.5 flex-1 flex flex-col justify-between space-y-2">
              <div>
                <h4 class="font-semibold text-slate-200 text-xs truncate title-text" title="${this.escapeHtml(item.title)}">${this.escapeHtml(item.title)}</h4>
                <p class="text-[10px] text-slate-400 mt-0.5">${new Date(item.createdAt).toLocaleString()} &bull; ${item.size}</p>
              </div>
              <div class="flex items-center justify-between pt-2 border-t border-slate-800/80">
                <div class="flex space-x-1.5">
                  <button class="btn-play p-1.5 rounded bg-slate-800 hover:bg-slate-700 text-indigo-400 text-xs" title="Play Preview"><i class="fa-solid fa-play"></i></button>
                  <button class="btn-download p-1.5 rounded bg-slate-800 hover:bg-slate-700 text-emerald-400 text-xs" title="Download"><i class="fa-solid fa-download"></i></button>
                  <button class="btn-rename p-1.5 rounded bg-slate-800 hover:bg-slate-700 text-amber-400 text-xs" title="Rename"><i class="fa-solid fa-pen"></i></button>
                </div>
                <button class="btn-delete p-1.5 rounded bg-slate-800 hover:bg-rose-900/50 text-rose-400 text-xs" title="Delete"><i class="fa-solid fa-trash"></i></button>
              </div>
            </div>
          `;

          // Card Action Listeners
          card.querySelector('.btn-play').addEventListener('click', () => {
            this.dom.exportVideo.src = videoUrl;
            this.dom.metaDuration.textContent = item.duration;
            this.dom.metaSize.textContent = item.size;
            this.dom.metaCodec.textContent = item.type;
            this.dom.metaRes.textContent = 'Stored Stream';
            this.currentBlob = item.blob;
            this.dom.modalExport.classList.remove('hidden');
          });

          card.querySelector('.btn-download').addEventListener('click', () => {
            const ext = this.getFileExtension(item.type);
            const a = document.createElement('a');
            a.href = videoUrl;
            a.download = `${item.title.replace(/[^a-z0-9]/gi, '_')}.${ext}`;
            a.click();
          });

          card.querySelector('.btn-rename').addEventListener('click', async () => {
            const newTitle = prompt('Enter new title:', item.title);
            if (newTitle && newTitle.trim()) {
              await this.db.renameRecording(item.id, newTitle.trim());
              this.renderLibraryItems();
              this.showToast('Recording renamed', 'info');
            }
          });

          card.querySelector('.btn-delete').addEventListener('click', async () => {
            if (confirm(`Delete "${item.title}"?`)) {
              await this.db.deleteRecording(item.id);
              this.renderLibraryItems();
              this.updateLibraryBadge();
              this.showToast('Recording deleted', 'info');
            }
          });

          this.dom.libraryList.appendChild(card);
        });
      }

      async updateLibraryBadge() {
        const items = await this.db.getAllRecordings();
        this.dom.libraryBadge.textContent = items.length;
      }

      // ==========================================
      // PIP DRAG ENGINE
      // ==========================================
      setupPipDrag() {
        const container = this.dom.webcamPipContainer;
        const previewBox = container.parentElement;
        let isDragging = false;
        let startX, startY, initialX, initialY;

        const onStart = (e) => {
          isDragging = true;
          const clientX = e.touches ? e.touches[0].clientX : e.clientX;
          const clientY = e.touches ? e.touches[0].clientY : e.clientY;
          startX = clientX;
          startY = clientY;
          initialX = container.offsetLeft;
          initialY = container.offsetTop;
          document.addEventListener('mousemove', onMove);
          document.addEventListener('mouseup', onEnd);
          document.addEventListener('touchmove', onMove);
          document.addEventListener('touchend', onEnd);
        };

        const onMove = (e) => {
          if (!isDragging) return;
          const clientX = e.touches ? e.touches[0].clientX : e.clientX;
          const clientY = e.touches ? e.touches[0].clientY : e.clientY;
          const dx = clientX - startX;
          const dy = clientY - startY;

          let newX = initialX + dx;
          let newY = initialY + dy;

          // Boundaries
          const maxW = previewBox.clientWidth - container.clientWidth;
          const maxH = previewBox.clientHeight - container.clientHeight;
          newX = Math.max(0, Math.min(newX, maxW));
          newY = Math.max(0, Math.min(newY, maxH));

          container.style.left = `${newX}px`;
          container.style.top = `${newY}px`;
          container.style.right = 'auto';

          // Update Compositor Ratios
          this.compositor.pipX = newX / previewBox.clientWidth;
          this.compositor.pipY = newY / previewBox.clientHeight;
        };

        const onEnd = () => {
          isDragging = false;
          document.removeEventListener('mousemove', onMove);
          document.removeEventListener('mouseup', onEnd);
          document.removeEventListener('touchmove', onMove);
          document.removeEventListener('touchend', onEnd);
        };

        container.addEventListener('mousedown', onStart);
        container.addEventListener('touchstart', onStart);
      }

      // ==========================================
      // VU METER LOOP & UTILS
      // ==========================================
      startVuMeterLoop() {
        const updateVu = () => {
          if (this.micStream) {
            const level = this.audioMixer.getMicLevel();
            const pct = Math.min(100, Math.max(0, (level / 128) * 100));
            this.dom.vuMeterBar.style.width = `${pct}%`;
          }
          requestAnimationFrame(updateVu);
        };
        updateVu();
      }

      updateTimer() {
        const now = Date.now();
        const diff = Math.floor((now - this.startTime - this.elapsedPausedTime) / 1000);
        const hrs = Math.floor(diff / 3600).toString().padStart(2, '0');
        const mins = Math.floor((diff % 3600) / 60).toString().padStart(2, '0');
        const secs = (diff % 60).toString().padStart(2, '0');
        this.dom.timerDisplay.textContent = `${hrs}:${mins}:${secs}`;
      }

      updateStatus(text, dotColorClass) {
        this.dom.statusText.textContent = text;
        this.dom.statusDot.className = `w-2.5 h-2.5 rounded-full ${dotColorClass}`;
      }

      getBestSupportedMimeType() {
        const types = [
          'video/webm;codecs=vp9,opus',
          'video/webm;codecs=vp8,opus',
          'video/webm;codecs=h264,opus',
          'video/webm',
          'video/mp4'
        ];
        for (const type of types) {
          if (MediaRecorder.isTypeSupported(type)) {
            return type;
          }
        }
        return '';
      }

      getResolutionDimensions(resString) {
        switch (resString) {
          case '720p': return { width: 1280, height: 720 };
          case '1440p': return { width: 2560, height: 1440 };
          case '4k': return { width: 3840, height: 2160 };
          case '1080p':
          default: return { width: 1920, height: 1080 };
        }
      }

      getFileExtension(mimeType) {
        if (mimeType.includes('mp4')) return 'mp4';
        return 'webm';
      }

      getTimestamp() {
        const d = new Date();
        return `${d.getFullYear()}${String(d.getMonth()+1).padStart(2,'0')}${String(d.getDate()).padStart(2,'0')}_${String(d.getHours()).padStart(2,'0')}${String(d.getMinutes()).padStart(2,'0')}`;
      }

      async generateThumbnail(videoElement) {
        return new Promise((resolve) => {
          try {
            const canvas = document.createElement('canvas');
            canvas.width = 320;
            canvas.height = 180;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
            resolve(canvas.toDataURL('image/jpeg', 0.7));
          } catch(e) {
            resolve(null);
          }
        });
      }

      escapeHtml(str) {
        return str.replace(/[&<>"']/g, (m) => ({
          '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
        }[m]));
      }

      showToast(message, type = 'info') {
        const toast = document.createElement('div');
        let iconClass = 'fa-circle-info text-indigo-400';
        let borderClass = 'border-indigo-500/40';

        if (type === 'success') {
          iconClass = 'fa-circle-check text-emerald-400';
          borderClass = 'border-emerald-500/40';
        } else if (type === 'warning') {
          iconClass = 'fa-triangle-exclamation text-amber-400';
          borderClass = 'border-amber-500/40';
        } else if (type === 'error') {
          iconClass = 'fa-circle-xmark text-rose-400';
          borderClass = 'border-rose-500/40';
        }

        toast.className = `glass-card px-4 py-3 rounded-xl border ${borderClass} shadow-2xl flex items-center space-x-3 text-xs text-slate-200 transform translate-y-2 opacity-0 transition-all duration-300 pointer-events-auto max-w-sm`;
        toast.innerHTML = `<i class="fa-solid ${iconClass} text-sm"></i><span>${message}</span>`;

        this.dom.toastContainer.appendChild(toast);

        requestAnimationFrame(() => {
          toast.classList.remove('translate-y-2', 'opacity-0');
        });

        setTimeout(() => {
          toast.classList.add('opacity-0', 'translate-y-2');
          setTimeout(() => toast.remove(), 300);
        }, 3500);
      }
    }

    // Initialize Application on DOM Ready
    window.addEventListener('DOMContentLoaded', () => {
      const app = new ScreenRecorderApp();
      app.init();
    });
  </script>
</body>
</html>