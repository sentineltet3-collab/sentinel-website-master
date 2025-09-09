// Sentinel Chatbot Script
// By GitHub Copilot

(function() {
  // Chatbot script tree
  const SCRIPT = {
    main: {
      message: "Hi! 👋 Welcome to Sentinel Integrated Security Services, Inc.<br>How can we assist you today?<br><br>Type a number (1-5) to choose:",
      options: [
        { text: "1️⃣ Services Offered", next: "services" },
        { text: "2️⃣ Business Inquiries", next: "business" },
        { text: "3️⃣ Job Opportunities", next: "jobs" },
        { text: "4️⃣ Office Info", next: "office" },
        { text: "5️⃣ Ask a Question", next: "ask" }
      ],
      input: true
    },
    services: {
      message: "We offer customizable services to match your needs. Please choose an option:",
      options: [
        { text: "• Security Personnel Deployment", next: "security" },
        { text: "• Human Resource Support Services", next: "hr" },
        { text: "• Back to Main Menu", next: "main" }
      ]
    },
    security: {
      message: "We deploy trained and licensed guards tailored to your site requirements.<br>Would you like to:",
      options: [
        { text: "• Request a Quote", next: "quote" },
        { text: "• Speak to a Representative", next: "rep" },
        { text: "• Back to Services Offered", next: "services" }
      ]
    },
    hr: {
      message: "We offer background checks, address verification, document validation, and more.<br>Would you like to:",
      options: [
        { text: "• Inquire About Services", next: "inquire" },
        { text: "• Speak to a Representative", next: "rep" },
        { text: "• Back to Services Offered", next: "services" }
      ]
    },
    business: {
      message: "Please choose what you'd like to do:",
      options: [
        { text: "• Request a Proposal", next: "proposal" },
        { text: "• Schedule a Meeting", next: "meeting" },
        { text: "• Contact Business Development", next: "bizdev" },
        { text: "• Back to Main Menu", next: "main" }
      ]
    },
    bizdev: {
      message: "You may reach our team at:<br>📧 services@sentinelphils.com<br>📞 (02) 8896-7544<br>You may also leave your message here.",
      options: [
        { text: "• Back to Business Inquiries", next: "business" }
      ]
    },
    jobs: {
      message: "Looking to join the Sentinel team? Choose from the options below:",
      options: [
        { text: "• View Qualifications", next: "qualifications" },
        { text: "• Apply Now", next: "apply" },
        { text: "• Recruitment Office Location", next: "recruitment" },
        { text: "• Back to Main Menu", next: "main" }
      ]
    },
    apply: {
      message: "Please send your resume to:<br>📧 dianejaneguillido@sentinelphils.com<br>Would you like our office location or contact number?",
      options: [
        { text: "• Recruitment Office Location", next: "recruitment" },
        { text: "• Back to Job Opportunities", next: "jobs" }
      ]
    },
    recruitment: {
      message: "📍 1757 Nicanor Garcia Street, San Miguel Village, Poblacion, Makati City<br>📞 (02) 8895 4720",
      options: [
        { text: "• Back to Job Opportunities", next: "jobs" }
      ]
    },
    office: {
      message: "📍 1757 Nicanor Garcia Street, San Miguel Village, Poblacion, Makati City<br>🕒 Monday–Friday: 8:30 AM – 6:00 PM<br>🕒 Saturday: 8:30 AM – 2:00 PM<br>📞 (02) 8895 4720 / (02) 8896-7544<br>📧 services@sentinelphils.com",
      options: [
        { text: "• Talk to an Agent", next: "rep" },
        { text: "• Back to Main Menu", next: "main" }
      ]
    },
    ask: {
      message: "Please type your question below 👇<br>Our team will respond shortly. For urgent matters, call us at (02) 8896-7544.",
      input: true,
      options: [
        { text: "• Back to Main Menu", next: "main" }
      ]
    },
    quote: {
      message: "A representative will contact you soon for your quote request.",
      options: [
        { text: "• Back to Security Personnel Deployment", next: "security" }
      ]
    },
    rep: {
      message: "A representative will be with you shortly. You may also call (02) 8896-7544.",
      options: [
        { text: "• Back to Main Menu", next: "main" }
      ]
    },
    inquire: {
      message: "Thank you for your inquiry. Our team will get in touch soon.",
      options: [
        { text: "• Back to Human Resource Support Services", next: "hr" }
      ]
    },
    proposal: {
      message: "Our business development team will reach out regarding your proposal request.",
      options: [
        { text: "• Back to Business Inquiries", next: "business" }
      ]
    },
    meeting: {
      message: "Please provide your preferred date and time. Our team will confirm your meeting soon.",
      input: true,
      options: [
        { text: "• Back to Business Inquiries", next: "business" }
      ]
    },
    qualifications: {
      message: "Qualifications vary by position. Please visit our Careers page for details.",
      options: [
        { text: "• Back to Job Opportunities", next: "jobs" }
      ]
    }
  };

  // Create chatbot button
  const btn = document.createElement('button');
  btn.className = 'sentinel-chatbot-btn';
  btn.innerHTML = '<i class="fas fa-comments"></i>';
  document.body.appendChild(btn);

  // Create chatbot window
  const win = document.createElement('div');
  win.className = 'sentinel-chatbot-window';
  win.innerHTML = `
    <div class="sentinel-chatbot-header">
      Sentinel Chatbot
      <button class="sentinel-chatbot-close">&times;</button>
    </div>
    <div class="sentinel-chatbot-messages"></div>
    <div class="sentinel-chatbot-options"></div>
    <div class="sentinel-chatbot-input" style="display:none;">
      <input type="text" placeholder="Type your message...">
      <button>Send</button>
    </div>
  `;
  document.body.appendChild(win);

  // Show/hide logic
  let chatbotOpen = false;
  btn.onclick = () => {
    chatbotOpen = !chatbotOpen;
    win.style.display = chatbotOpen ? 'flex' : 'none';
  };
  win.querySelector('.sentinel-chatbot-close').onclick = () => {
    win.style.display = 'none';
    chatbotOpen = false;
  };

  // Chatbot state
  let state = 'main';
  const messagesDiv = win.querySelector('.sentinel-chatbot-messages');
  const optionsDiv = win.querySelector('.sentinel-chatbot-options');
  const inputDiv = win.querySelector('.sentinel-chatbot-input');
  const inputBox = inputDiv.querySelector('input');
  const sendBtn = inputDiv.querySelector('button');

  function showState(newState, userMsg) {
    state = newState;
    const node = SCRIPT[state];
    if (userMsg) {
      messagesDiv.innerHTML += `<div style='text-align:right;margin:8px 0;'><span style='background:#e8f5e9;color:#1b5e20;padding:6px 12px;border-radius:8px;display:inline-block;'>${userMsg}</span></div>`;
    }
    messagesDiv.innerHTML += `<div style='margin:8px 0;'><span style='background:#4CAF50;color:#fff;padding:6px 12px;border-radius:8px;display:inline-block;'>${node.message}</span></div>`;
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
    optionsDiv.innerHTML = '';
    inputDiv.style.display = node.input ? 'flex' : 'none';
    // Always show choices in main menu, even with input
    if (state === 'main' && node.options) {
      node.options.forEach(opt => {
        const b = document.createElement('button');
        b.className = 'sentinel-chatbot-option';
        b.textContent = opt.text;
        b.disabled = true;
        optionsDiv.appendChild(b);
      });
    }
    if (node.options && !node.input) {
      node.options.forEach(opt => {
        const b = document.createElement('button');
        b.className = 'sentinel-chatbot-option';
        b.textContent = opt.text;
        b.onclick = () => {
          showState(opt.next, opt.text);
        };
        optionsDiv.appendChild(b);
      });
    }
    if (node.input) {
      inputBox.value = '';
      sendBtn.onclick = () => {
        handleInput(inputBox.value.trim());
      };
      inputBox.onkeydown = e => {
        if (e.key === 'Enter') sendBtn.click();
      };
    }
  }

  function handleInput(val) {
    if (state === 'main') {
      switch(val) {
        case '1': showState('services', val); break;
        case '2': showState('business', val); break;
        case '3': showState('jobs', val); break;
        case '4': showState('office', val); break;
        case '5': showState('ask', val); break;
        default:
          showState('main', val);
          messagesDiv.innerHTML += `<div style='margin:8px 0;'><span style='background:#ffebee;color:#c62828;padding:6px 12px;border-radius:8px;display:inline-block;'>Please type a number (1-5) to choose an option.</span></div>`;
          messagesDiv.scrollTop = messagesDiv.scrollHeight;
      }
      return;
    }
    // For other states with input, just echo and go back to main
    showState('main', val);
  }

  // Start chatbot
  showState('main');
})();
