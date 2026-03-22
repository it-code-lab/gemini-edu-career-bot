<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Hub Assistant</title>
    <style>
        :root { --primary: #2563eb; --bg: #f8fafc; --text: #1e293b; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: var(--bg); color: var(--text); display: flex; justify-content: center; padding: 20px; }
        #app-container { width: 100%; max-width: 600px; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .step { display: none; animation: fadeIn 0.3s ease-in; }
        .step.active { display: block; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 20px; }
        button.opt { background: white; border: 1px solid #e2e8f0; padding: 15px; border-radius: 12px; cursor: pointer; transition: 0.2s; font-size: 0.95rem; text-align: left; }
        button.opt:hover { border-color: var(--primary); background: #eff6ff; }
        .progress-container { height: 4px; background: #e2e8f0; margin-bottom: 25px; border-radius: 2px; }
        #progress-bar { height: 100%; background: var(--primary); width: 0%; transition: 0.4s; }
        textarea { width: 100%; height: 120px; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; box-sizing: border-box; }
        .rec-active { color: red; font-weight: bold; animation: blink 1s infinite; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes blink { 50% { opacity: 0; } }
        .hidden { display: none; }
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>

<div id="app-container">
    <div class="progress-container"><div id="progress-bar"></div></div>

    <form id="mainForm">
        <div class="step active" id="s0">
            <h2 style="text-align:center;">Choose Language / भाषा चुनें</h2>
            <div class="grid">
                <button type="button" class="opt" onclick="setLang('en')">English</button>
                <button type="button" class="opt" onclick="setLang('hi')">हिन्दी</button>
            </div>
        </div>

        <div class="step" id="s1">
            <h2 id="q1">What would you like to do?</h2>
            <div id="intent-opts" class="grid"></div>
        </div>

        <div class="step" id="s2">
            <h2 id="q2">Which area is this about?</h2>
            <div id="theme-opts" class="grid"></div>
        </div>

        <div class="step" id="s3">
            <h2 id="q3">Who are you?</h2>
            <div id="utype-opts" class="grid"></div>
        </div>

        <div class="step" id="s4">
            <h2 id="q4">Your Details</h2>
            <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                <button type="button" onclick="showInput('text')" id="btn-t" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; cursor: pointer; background: #fff;">
                    <span>⌨️</span> <span id="lbl-type">Type</span>
                </button>
                <button type="button" onclick="showInput('voice')" id="btn-v" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; cursor: pointer; background: #fff;">
                    <span>🎤</span> <span id="lbl-voice">Voice</span>
                </button>
            </div>

            <div id="text-input">
                <textarea name="query" id="queryText"></textarea>
            </div>

            <div id="voice-input" class="hidden" style="text-align:center;">
                <p id="rec-status">Ready to record</p>
                <button type="button" id="startBtn" class="opt" style="width:100%">🎤 Start Recording</button>
                <button type="button" id="stopBtn" class="opt hidden" style="width:100%; color:red;">Stop Recording</button>
                <audio id="audioPlay" controls class="hidden" style="margin-top:10px; width:100%"></audio>
            </div>

            <div style="margin-top:20px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <input type="text" name="user_name" placeholder="Name (Optional)" style="padding:10px; border-radius:8px; border:1fr solid #e2e8f0;">
                <input type="email" name="user_email" placeholder="Email (Optional)" style="padding:10px; border-radius:8px; border:1fr solid #e2e8f0;">
                <input type="text" name="user_region" placeholder="Country/Region (Optional)" style="grid-column: span 2; padding:10px; border-radius:8px; border:1fr solid #e2e8f0;">
            </div>

            <div style="margin-top:20px;display: none;">
                <label id="lbl-stage">Current Stage:</label>
                <select name="stage" id="stage-select" style="width:100%; padding:10px; margin-top:5px; border-radius:8px;"></select>
            </div>

            <div style="margin-top:15px;">
                <label><input type="checkbox" name="anon" value="1" checked> <span id="lbl-anon">You may use this anonymously in content</span></label>
            </div>

            <button type="submit" style="width:100%; padding:15px; background:var(--primary); color:white; border:none; border-radius:12px; margin-top:20px; font-weight:bold; cursor:pointer;">SUBMIT</button>
        </div>
        <!-- <div class="step" id="s4">
            <h2 id="q4">Your Details</h2>
            <div style="margin-bottom:15px;">
                <button type="button" onclick="showInput('text')" id="btn-t">Type</button>
                <button type="button" onclick="showInput('voice')" id="btn-v">Voice</button>
            </div>

            <div id="text-input">
                <textarea name="query" id="queryText"></textarea>
            </div>

            <div id="voice-input" class="hidden" style="text-align:center;">
                <p id="rec-status">Ready to record</p>
                <button type="button" id="startBtn" class="opt" style="width:100%">🎤 Start Recording</button>
                <button type="button" id="stopBtn" class="opt hidden" style="width:100%; color:red;">Stop Recording</button>
                <audio id="audioPlay" controls class="hidden" style="margin-top:10px; width:100%"></audio>
            </div>

            <div style="margin-top:20px; display: none;">
                <label id="lbl-stage">Current Stage:</label>
                <select name="stage" id="stage-select" style="width:100%; padding:10px; margin-top:5px; border-radius:8px;"></select>
            </div>

            <div style="margin-top:15px;">
                <label><input type="checkbox" name="anon" value="1"> <span id="lbl-anon">You may use this anonymously in content</span></label>
            </div>

            <button type="submit" style="width:100%; padding:15px; background:var(--primary); color:white; border:none; border-radius:12px; margin-top:20px; font-weight:bold; cursor:pointer;">SUBMIT</button>
        </div> -->
    </form>
    <div id="thank-you" class="hidden" style="text-align:center; padding:40px;">
        <h2 id="msg-thanks">Thank You!</h2>
        <p id="msg-sub">We received your input.</p>
    </div>
</div>

<script>
    const data = {
        en: {
            intents: ["Ask a question", "Share a problem", "Suggest a topic for video", "Request guidance", "Provide Feedback", "Share Experience"],
            themes: ["School studies", "College education", "Career choice", "Job search", "Resume / CV Help", "Interview prep", "Skills improvement", "Study abroad", "Exams Help", "Time management", "Career switch", "Freelancing Advice", "Parenting Advice", "Other"],
            utypes: ["School Student", "College Student", "Recent Graduate", "Working Professional", "Job Seeker", "Parent", "Mentor", "Other"],
            stages: ["Class 8-10", "Class 11-12", "Graduation", "Working 0-3 yrs", "Working 3-10 yrs", "Working 10+ yrs", "Parent of student", "Other"],
            q1: "What would you like to do?", q2: "Which area is this about?", q3: "Who are you?", q4: "Final Details",
            lbl_stage: "Current Stage:", lbl_anon: "You may use this anonymously in content", thanks: "Thank You!", msg: "Your input helps the community.",
            lbl_type: "Type",
            lbl_voice: "Voice",
        },
        hi: {
            intents: ["सवाल पूछें", "समस्या साझा करें", "वीडियो के लिए एक विषय सुझाएं", "मार्गदर्शन का अनुरोध करें", "फीडबैक साझा करें", "अनुभव साझा करें"],
            themes: ["स्कूली पढ़ाई", "कॉलेज शिक्षा", "करियर चुनाव", "नौकरी खोज", "रिज्यूमे / सीवी सहायता", "इंटरव्यू तैयारी", "कौशल सुधार सहायता", "विदेश में पढ़ाई", "परीक्षा सहायता", "समय प्रबंधन", "करियर बदलाव", "फ्रीलांसिंग सलाह", "पेरेंटिंग सलाह", "अन्य"],
            utypes: ["स्कूली छात्र", "कॉलेज छात्र", "स्नातक", "कार्यरत प्रोफेशनल", "नौकरी चाहने वाले", "अभिभावक", "मार्गदर्शक", "अन्य"],
            stages: ["कक्षा 8-10", "कक्षा 11-12", "ग्रेजुएशन", "कार्य 0-3 वर्ष", "कार्य 3-10 वर्ष", "कार्य 10+ वर्ष", "छात्र के अभिभावक", "अन्य"],
            q1: "आज आप क्या करना चाहेंगे?", q2: "यह किस विषय के बारे में है?", q3: "आप कौन हैं?", q4: "अंतिम विवरण",
            lbl_stage: "वर्तमान स्थिति:", lbl_anon: "इसका उपयोग वीडियो में गुमनाम रूप से कर सकते हैं।", thanks: "धन्यवाद!", msg: "आपका इनपुट समुदाय की मदद करता है।",
            lbl_type: "लिखें",
            lbl_voice: "बोलें",
        }
    };

    let selections = { lang: 'en', intent: '', theme: '', utype: '' };
    let mediaRecorder; let chunks = [];

    function setLang(l) {
        selections.lang = l;
        const t = data[l];
        document.getElementById('q1').innerText = t.q1;
        document.getElementById('q2').innerText = t.q2;
        document.getElementById('q3').innerText = t.q3;
        document.getElementById('q4').innerText = t.q4;
        document.getElementById('lbl-stage').innerText = t.lbl_stage;
        document.getElementById('lbl-anon').innerText = t.lbl_anon;
        document.getElementById('msg-thanks').innerText = t.thanks;
        document.getElementById('msg-sub').innerText = t.msg;

        document.getElementById('lbl-type').innerText = t.lbl_type;
        document.getElementById('lbl-voice').innerText = t.lbl_voice;

        renderOpts('intent-opts', t.intents, 'intent', 2);
        renderOpts('theme-opts', t.themes, 'theme', 3);
        renderOpts('utype-opts', t.utypes, 'utype', 4);
        
        const sel = document.getElementById('stage-select');
        sel.innerHTML = '';
        t.stages.forEach(s => sel.add(new Option(s, s)));
        
        go(1);
    }

    function renderOpts(id, list, key, next) {
        const div = document.getElementById(id);
        div.innerHTML = '';
        list.forEach(item => {
            const b = document.createElement('button');
            b.type = 'button'; b.className = 'opt'; b.innerText = item;
            b.onclick = () => { selections[key] = item; go(next); };
            div.appendChild(b);
        });
    }

    function go(s) {
        document.querySelectorAll('.step').forEach(div => div.classList.remove('active'));
        document.getElementById('s' + s).classList.add('active');
        document.getElementById('progress-bar').style.width = (s * 25) + '%';
    }

    // function showInput(mode) {
    //     document.getElementById('text-input').classList.toggle('hidden', mode === 'voice');
    //     document.getElementById('voice-input').classList.toggle('hidden', mode === 'text');
    // }

    function showInput(mode) {
        const btnT = document.getElementById('btn-t');
        const btnV = document.getElementById('btn-v');

        document.getElementById('text-input').classList.toggle('hidden', mode === 'voice');
        document.getElementById('voice-input').classList.toggle('hidden', mode === 'text');

        // Visual toggle
        if (mode === 'text') {
            btnT.style.borderColor = 'var(--primary)';
            btnT.style.background = '#eff6ff';
            btnV.style.borderColor = '#e2e8f0';
            btnV.style.background = '#fff';
        } else {
            btnV.style.borderColor = 'var(--primary)';
            btnV.style.background = '#eff6ff';
            btnT.style.borderColor = '#e2e8f0';
            btnT.style.background = '#fff';
        }
    }    
    // Voice Recorder Logic
    document.getElementById('startBtn').onclick = async () => {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        mediaRecorder = new MediaRecorder(stream);
        chunks = [];
        mediaRecorder.ondataavailable = e => chunks.push(e.data);
        mediaRecorder.onstop = () => {
            const blob = new Blob(chunks, { type: 'audio/webm' });
            const url = URL.createObjectURL(blob);
            document.getElementById('audioPlay').src = url;
            document.getElementById('audioPlay').classList.remove('hidden');
            window.recordedAudio = blob;
        };
        mediaRecorder.start();
        document.getElementById('startBtn').classList.add('hidden');
        document.getElementById('stopBtn').classList.remove('hidden');
        document.getElementById('rec-status').className = 'rec-active';
    };

    document.getElementById('stopBtn').onclick = () => {
        mediaRecorder.stop();
        document.getElementById('stopBtn').classList.add('hidden');
        document.getElementById('startBtn').classList.remove('hidden');
        document.getElementById('rec-status').className = '';
    };

    // AJAX Submission
    document.getElementById('mainForm').onsubmit = async (e) => {
        e.preventDefault();
        const fd = new FormData(e.target);
        fd.append('lang', selections.lang);
        fd.append('intent', selections.intent);
        fd.append('theme', selections.theme);
        fd.append('utype', selections.utype);
        if(window.recordedAudio) fd.append('audio_file', window.recordedAudio, 'voice.webm');

        const res = await fetch('submit.php', { method: 'POST', body: fd });
        if(res.ok) {
            document.getElementById('mainForm').classList.add('hidden');
            document.getElementById('thank-you').classList.remove('hidden');
            document.getElementById('progress-bar').style.width = '100%';
        }
    };
</script>
</body>
</html>