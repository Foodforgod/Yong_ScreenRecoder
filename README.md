Web-Based Screen Recorder and Video Capture System
A professional, feature-rich, web-based screen recording and video capture system built entirely with modern native browser APIs. No external backend, database, or heavy frameworks required—everything runs locally in your browser.

🚀 Features
Screen & Window Capture: Record your entire monitor, a specific application window, or a browser tab using the getDisplayMedia API.

Studio Mode (Webcam Picture-in-Picture): Enable your webcam as a resizable, draggable overlay composited directly into the video stream via the HTML Canvas API.

Audio Mixing: Capture microphone audio and system audio (where supported by browser/source) simultaneously via the Web Audio API.

Live Audio Visualizer: Real-time microphone audio-level feedback meter.

Recording Lifecycle: Full start, pause, resume, and stop controls with dynamic duration timers.

Configurable Settings: Adjust resolution (720p, 1080p, etc.), frame rates (30/60 FPS), bitrates, echo cancellation, and noise suppression.

Local Recordings Library: Store, preview, rename, and download past recordings directly using browser storage.

Snapshot Export: Capture instant PNG image snapshots from your recordings.

Glassmorphism UI: Modern dark-navy theme with sleek translucent cards, smooth transitions, and toast notifications.

🛠️ Technology Stack
Frontend: HTML5, CSS3, JavaScript (ES Modules)

Media Capture: getDisplayMedia, getUserMedia

Recording: MediaRecorder API

Audio Processing: Web Audio API (AudioContext, MediaStreamAudioSourceNode, GainNode)

Video Composition: HTML Canvas API (captureStream())

Storage: Browser Local Storage / IndexedDB

Styling: Custom CSS with CSS Variables and Flexbox/Grid

📁 Project Structure
Plaintext
screen-recorder/
├── index.html          # Main application markup and embedded CSS/JS
├── README.md           # Project documentation and usage instructions
(Note: You can easily split the code into the recommended modular structure css/, js/recorder.js, js/audio-mixer.js, etc., as your project scales).

⚙️ Installation & Setup
Clone or Download the project files into a local directory.

Open via a Local Development Server:

Because browsers require a secure context (https:// or http://localhost) to grant permissions for screen sharing (getDisplayMedia) and camera/microphone access (getUserMedia), opening index.html directly via the file:// protocol will cause permission errors.

Recommended method: Use the Live Server extension in VS Code. Right-click index.html and select "Open with Live Server".

Open in Browser: Navigate to http://localhost:5500 (or whichever port your local server assigns).

📖 Usage Guide
<img width="1912" height="952" alt="image" src="https://github.com/user-attachments/assets/713898d3-90c3-4aae-83e0-28acd82328ad" />

Select Source: Click Screen Selection to choose whether you want to share your entire screen, a window, or a specific browser tab.
<img width="1917" height="993" alt="image" src="https://github.com/user-attachments/assets/de4d77dd-3279-47c4-bc69-b64f33abe6c2" />

Configure Settings: Open the Settings panel to adjust your preferred resolution, frame rate, and audio filters (echo cancellation, noise suppression).
<img width="1917" height="933" alt="image" src="https://github.com/user-attachments/assets/0bb428d7-86be-4cea-bd7c-08ccb0590ca3" />

Enable Audio & Webcam (Optional): Toggle your microphone or webcam on. If Studio Mode is enabled, your webcam feed will be composited live onto the recording canvas.
<img width="1887" height="932" alt="image" src="https://github.com/user-attachments/assets/3342fddd-a5a1-4531-9465-c2cf94f68959" />

Record: Click Start Recording. A live timer will indicate your active recording session. You can pause and resume at any time.
<img width="1917" height="926" alt="image" src="https://github.com/user-attachments/assets/2ab126ab-1c67-43ef-8a99-b2e69f0eb2ef" />

Stop & Preview: Click Stop Recording. The preview and export panel will appear, allowing you to play back your video, download it locally, capture a snapshot, or save it to your recordings library.

Manage Library: Access your saved recordings anytime via the Recordings Library button to review, rename, download, or delete past captures.

⚠️ Browser Compatibility & Permissions
HTTPS / Localhost Requirement: Screen and media capture APIs require a secure context.

System Permissions (macOS/Linux): If screen capture fails or throws a NotAllowedError, ensure your operating system has granted your browser permission to record the screen (e.g., System Settings > Privacy & Security > Screen Recording on macOS).

System Audio: System audio capture depends heavily on the browser and operating system (fully supported on Chrome/Edge when sharing a tab or entire screen with system audio enabled).
