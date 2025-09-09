// Animate sections on scroll (fade-in)
document.addEventListener('DOMContentLoaded', function() {
    const animatedSections = document.querySelectorAll('section, .hero, .about-header, .about-split, .portfolio-header, .portfolio-grid, .latest-events, .careers-container, .footer-hero, .footer-content, .footer-bottom');
    animatedSections.forEach(section => {
        section.classList.add('animate-on-scroll');
    });

    function revealOnScroll() {
        animatedSections.forEach(section => {
            const rect = section.getBoundingClientRect();
            if (rect.top < window.innerHeight - 100) {
                section.classList.add('visible');
            } else {
                section.classList.remove('visible');
            }
        });
    }
    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll();
});
document.addEventListener('DOMContentLoaded', function() {
    const advantageItems = document.querySelectorAll('.advantage-item');

    advantageItems.forEach(item => {
        const header = item.querySelector('h4');
        const content = item.querySelector('p');
        const icon = item.querySelector('.toggle-icon');

        // Set initial state for non-active items
        if (!item.classList.contains('active')) {
            content.style.display = 'none';
            content.style.opacity = '0';
            content.style.height = '0';
        }

        header.addEventListener('click', () => {
            const isActive = item.classList.contains('active');

            // Close all items
            advantageItems.forEach(i => {
                const otherContent = i.querySelector('p');
                const otherIcon = i.querySelector('.toggle-icon');

                if (i !== item) {
                    i.classList.remove('active');
                    otherContent.style.display = 'none';
                    otherContent.style.opacity = '0';
                    otherContent.style.height = '0';
                    otherIcon.textContent = '+';
                    otherIcon.style.transform = 'rotate(0deg)';
                }
            });

            // Toggle clicked item
            if (!isActive) {
                item.classList.add('active');
                content.style.display = 'block';
                // Trigger reflow for transition
                void content.offsetHeight;
                content.style.opacity = '1';
                content.style.height = 'auto';
                icon.textContent = '−';
                icon.style.transform = 'rotate(0deg)';
            } else {
                item.classList.remove('active');
                content.style.opacity = '0';
                content.style.height = '0';
                setTimeout(() => {
                    content.style.display = 'none';
                }, 300); // Match this with CSS transition duration
                icon.textContent = '+';
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });
});

// Function to animate counting numbers Home pag stats
function animateCounting() {
    const statNumbers = document.querySelectorAll('.stat-number');

    statNumbers.forEach(statNumber => {
        const target = parseInt(statNumber.getAttribute('data-target'));
        let count = 0;
        const increment = target / 50; // Adjust speed by changing the divisor
        const timer = setInterval(() => {
            count += increment;
            if (count >= target) {
                count = target;
                clearInterval(timer);
            }
            statNumber.textContent = Math.floor(count) + "+";
        }, 30); // Adjust the interval for smoother/faster animation
    });
}

// Function to check if an element is in the viewport
function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.bottom >= 0
    );
}

// Function to handle scroll event
function handleScroll() {
    const statsSection = document.querySelector('.stats-section');
    if (isElementInViewport(statsSection)) {
        animateCounting();
        window.removeEventListener('scroll', handleScroll); // Remove listener after animation
    }
}

// Add scroll event listener (other services )
window.addEventListener('scroll', handleScroll);


document.addEventListener('DOMContentLoaded', function() {
    const teamMembers = document.querySelectorAll('.team-member');
    const popup = document.querySelector('.member-popup');
    const closePopup = document.querySelector('.close-popup');
    const popupMembers = document.querySelectorAll('.popup-member');

    teamMembers.forEach(member => {
        member.addEventListener('click', () => {
            const memberId = member.getAttribute('data-member');
            popupMembers.forEach(popupMember => {
                popupMember.style.display = 'none';
            });
            document.getElementById(memberId).style.display = 'flex';
            popup.style.display = 'flex'; /* Use flex to center popup */
        });
    });

    closePopup.addEventListener('click', () => {
        popup.style.display = 'none';
    });

    popup.addEventListener('click', (e) => {
        if (e.target === popup) {
            popup.style.display = 'none';
        }
    });
});

// REMOVE OLD CHATBOT WIDGET
const oldWidget = document.querySelector('.chatbot-widget');
if (oldWidget) oldWidget.remove();

// Simple Chatbot Widget
document.addEventListener('DOMContentLoaded', function() {
    const widget = document.querySelector('.chatbot-widget');
    if (!widget) return;

    const toggleBtn = widget.querySelector('.chatbot-toggle');
    const panel = widget.querySelector('.chatbot-panel');
    const closeBtn = widget.querySelector('.chatbot-close');
    const input = widget.querySelector('.chatbot-input');
    const sendBtn = widget.querySelector('.chatbot-send');
    const messages = widget.querySelector('.chatbot-messages');

    function openPanel() { panel.style.display = 'block'; input.focus(); }
    function closePanel() { panel.style.display = 'none'; }
    toggleBtn.addEventListener('click', () => {
        const isOpen = panel.style.display === 'block';
        isOpen ? closePanel() : openPanel();
    });
    closeBtn.addEventListener('click', closePanel);

    function appendMessage(text, who = 'bot') {
        const div = document.createElement('div');
        div.className = `chatbot-msg ${who}`;
        div.textContent = text;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function reply(userText) {
        const t = userText.toLowerCase();
        if (!t.trim()) return;
        // Basic intents
        if (t.includes('careers') || t.includes('job') || t.includes('apply')) {
            appendMessage('You can apply on our Careers page. Need the link? Go to CAREERS in the menu.');
        } else if (t.includes('contact') || t.includes('email') || t.includes('phone')) {
            appendMessage('Contact us at services@sentinelphils.com or +(632) 8896-4109. You can also see details on the Contact page.');
        } else if (t.includes('service') || t.includes('security') || t.includes('sentinel')) {
            appendMessage('We provide human resource support, crisis management, event security, VIP protection, audits, and surveillance. Which one are you interested in?');
        } else if (t.includes('hello') || t.includes('hi') || t.includes('good')) {
            appendMessage('Hello! How can I help you today?');
        } else {
            appendMessage('Thanks! I have noted your question. For complex inquiries, please message us via the Contact page and our team will respond.');
        }
    }

    function sendCurrent() {
        const text = input.value;
        if (!text.trim()) return;
        appendMessage(text, 'user');
        input.value = '';
        setTimeout(() => reply(text), 300);
    }

    sendBtn.addEventListener('click', sendCurrent);
    input.addEventListener('keydown', (e) => { if (e.key === 'Enter') sendCurrent(); });
});

// Tabs hover/click activation for Other Services
document.addEventListener('DOMContentLoaded', function() {
	const otherServicesSection = document.querySelector('.other-services');
	if (!otherServicesSection) return;

	const tabButtons = document.querySelectorAll('.tab-button');
	const tabContents = document.querySelectorAll('.tab-content');

	function activateTabById(tabId) {
		tabButtons.forEach(btn => {
			btn.classList.toggle('active', btn.getAttribute('data-tab') === tabId);
		});
		tabContents.forEach(content => {
			content.classList.toggle('active', content.id === tabId);
		});
	}

	tabButtons.forEach(button => {
		const tabId = button.getAttribute('data-tab');
		// Activate on hover for desktop
		button.addEventListener('mouseenter', () => activateTabById(tabId));
		// Also support click/tap
		button.addEventListener('click', (e) => {
			e.preventDefault();
			activateTabById(tabId);
		});
	});
});


// Enhanced Timeline functionality with smooth animations
document.addEventListener('DOMContentLoaded', function() {
    const timelineSection = document.querySelector('.timeline-section');
    if (!timelineSection) return;

    const timelineHeader = document.querySelector('.timeline-header');
    const timelineTitle = document.querySelector('.timeline-title');
    const timelineMarkers = Array.from(document.querySelectorAll('.timeline-marker'));
    const timelineCards = Array.from(document.querySelectorAll('.timeline-card'));
    const prevArrow = document.querySelector('.prev-arrow');
    const nextArrow = document.querySelector('.next-arrow');
    const timelineBar = document.querySelector('.timeline-bar');

    let currentIndex = Math.max(0, timelineCards.findIndex(c => c.classList.contains('active')));
    if (currentIndex === -1) currentIndex = 0;
    let isTimelineInitialized = false;

    // Initialize timeline with smooth entrance animations
    function initializeTimeline() {
        if (isTimelineInitialized) return;
        isTimelineInitialized = true;

        // Animate timeline header entrance
        if (timelineHeader) {
            timelineHeader.style.opacity = '0';
            timelineHeader.style.transform = 'translateY(-30px)';
            timelineHeader.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            
            setTimeout(() => {
                timelineHeader.style.opacity = '1';
                timelineHeader.style.transform = 'translateY(0)';
            }, 200);
        }

        // Animate timeline bar entrance
        if (timelineBar) {
            timelineBar.style.opacity = '0';
            timelineBar.style.transform = 'scaleX(0)';
            timelineBar.style.transition = 'opacity 0.6s ease, transform 0.8s ease';
            timelineBar.style.transformOrigin = 'center';
            
            setTimeout(() => {
                timelineBar.style.opacity = '1';
                timelineBar.style.transform = 'scaleX(1)';
            }, 600);
        }

        // Animate markers entrance with stagger
        timelineMarkers.forEach((marker, index) => {
            marker.style.opacity = '0';
            marker.style.transform = 'translateX(-50%) translateY(-20px) scale(0.8)';
            marker.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            
            setTimeout(() => {
                marker.style.opacity = '1';
                marker.style.transform = 'translateX(-50%) translateY(0) scale(1)';
            }, 800 + (index * 100));
        });

        // Animate arrows entrance
        [prevArrow, nextArrow].forEach((arrow, index) => {
            if (arrow) {
                arrow.style.opacity = '0';
                arrow.style.transform = 'scale(0.8)';
                arrow.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                
                setTimeout(() => {
                    arrow.style.opacity = '1';
                    arrow.style.transform = 'scale(1)';
                }, 1000 + (index * 100));
            }
        });

        // Animate first timeline card entrance
        if (timelineCards[currentIndex]) {
            timelineCards[currentIndex].style.opacity = '0';
            timelineCards[currentIndex].style.transform = 'translateY(30px)';
            timelineCards[currentIndex].style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            
            setTimeout(() => {
                timelineCards[currentIndex].style.opacity = '1';
                timelineCards[currentIndex].style.transform = 'translateY(0)';
            }, 1200);
        }
    }

    // Ensure only current is visible
    timelineCards.forEach((card, i) => {
        if (i !== currentIndex) {
            card.style.display = 'none';
            card.style.opacity = '0';
            card.style.transform = 'translateY(12px)';
        }
    });

    function setActiveMarker(index) {
        timelineMarkers.forEach((m, i) => {
            const isActive = i === index;
            m.classList.toggle('active', isActive);
            
            // Smooth marker animation
            if (isActive) {
                m.style.transform = 'translateX(-50%) scale(1.15)';
                m.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                
                // Add pulse effect
                m.style.animation = 'timelineMarkerPulse 0.6s ease-out';
            } else {
                m.style.transform = 'translateX(-50%) scale(1)';
                m.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                m.style.animation = 'none';
            }
        });
    }

    setActiveMarker(currentIndex);

    let isAnimating = false;
    const ENTER_MS = 500;

    function animateTo(index) {
        if (isAnimating || index === currentIndex || index < 0 || index >= timelineCards.length) return;
        isAnimating = true;

        const outgoing = timelineCards[currentIndex];
        const incoming = timelineCards[index];

        // Add smooth transition effects
        timelineTitle.style.transition = 'transform 0.3s ease, opacity 0.3s ease';
        timelineTitle.style.transform = 'scale(0.98)';
        timelineTitle.style.opacity = '0.8';

        // Prepare incoming card
        incoming.style.display = 'block';
        incoming.style.opacity = '0';
        incoming.style.transform = 'translateY(30px) scale(0.95)';
        incoming.style.transition = 'none';

        // Animate with enhanced easing
        requestAnimationFrame(() => {
            incoming.style.transition = 'opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1), transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            outgoing.style.transition = 'opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1), transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)';

            incoming.style.opacity = '1';
            incoming.style.transform = 'translateY(0) scale(1)';

            outgoing.style.opacity = '0';
            outgoing.style.transform = 'translateY(-20px) scale(1.02)';

            // Reset title animation
            setTimeout(() => {
                timelineTitle.style.transform = 'scale(1)';
                timelineTitle.style.opacity = '1';
            }, 200);

            setTimeout(() => {
                // Cleanup
                outgoing.style.display = 'none';
                outgoing.style.opacity = '';
                outgoing.style.transform = '';
                outgoing.style.transition = '';

                incoming.style.opacity = '';
                incoming.style.transform = '';
                incoming.style.transition = '';

                timelineCards.forEach(c => c.classList.remove('active'));
                incoming.classList.add('active');

                currentIndex = index;
                setActiveMarker(currentIndex);
                isAnimating = false;
            }, ENTER_MS);
        });
    }

    // Enhanced marker click with ripple effect
    timelineMarkers.forEach((marker, index) => {
        marker.addEventListener('click', () => {
            // Add ripple effect
            const ripple = document.createElement('div');
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(46, 125, 50, 0.3)';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'ripple 0.6s linear';
            ripple.style.left = '50%';
            ripple.style.top = '50%';
            ripple.style.width = '40px';
            ripple.style.height = '40px';
            ripple.style.marginLeft = '-20px';
            ripple.style.marginTop = '-20px';
            ripple.style.pointerEvents = 'none';
            
            marker.style.position = 'relative';
            marker.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
            
            animateTo(index);
        });

        // Add hover effects
        marker.addEventListener('mouseenter', () => {
            if (!marker.classList.contains('active')) {
                marker.style.transform = 'translateX(-50%) scale(1.05)';
                marker.style.transition = 'transform 0.2s ease';
            }
        });

        marker.addEventListener('mouseleave', () => {
            if (!marker.classList.contains('active')) {
                marker.style.transform = 'translateX(-50%) scale(1)';
            }
        });
    });

    // Enhanced arrow animations
    function animateArrow(arrow, direction) {
        arrow.style.transform = `scale(0.9) translateX(${direction === 'prev' ? '-2px' : '2px'})`;
        arrow.style.transition = 'transform 0.1s ease';
        
        setTimeout(() => {
            arrow.style.transform = 'scale(1) translateX(0)';
        }, 100);
    }

    if (prevArrow) {
        prevArrow.addEventListener('click', () => {
            animateArrow(prevArrow, 'prev');
            const newIndex = currentIndex > 0 ? currentIndex - 1 : timelineCards.length - 1;
            animateTo(newIndex);
        });
    }

    if (nextArrow) {
        nextArrow.addEventListener('click', () => {
            animateArrow(nextArrow, 'next');
            const newIndex = currentIndex < timelineCards.length - 1 ? currentIndex + 1 : 0;
            animateTo(newIndex);
        });
    }

    // Keyboard navigation with enhanced feedback
    document.addEventListener('keydown', (e) => {
        if (!(timelineSection.contains(document.activeElement) || timelineSection.matches(':hover'))) return;
        
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            const newIndex = currentIndex > 0 ? currentIndex - 1 : timelineCards.length - 1;
            animateTo(newIndex);
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            const newIndex = currentIndex < timelineCards.length - 1 ? currentIndex + 1 : 0;
            animateTo(newIndex);
        }
    });

    // Auto-play functionality (optional)
    let autoPlayInterval;
    let isAutoPlaying = false;

    function startAutoPlay() {
        if (isAutoPlaying) return;
        isAutoPlaying = true;
        autoPlayInterval = setInterval(() => {
            const newIndex = currentIndex < timelineCards.length - 1 ? currentIndex + 1 : 0;
            animateTo(newIndex);
        }, 5000); // Change every 5 seconds
    }

    function stopAutoPlay() {
        isAutoPlaying = false;
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
        }
    }

    // Initialize timeline only when it comes into view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Initialize timeline animations when it comes into view
                initializeTimeline();
                startAutoPlay();
            } else {
                stopAutoPlay();
            }
        });
    }, { threshold: 0.3 }); // Trigger when 30% of timeline is visible

    observer.observe(timelineSection);

    // Stop auto-play on user interaction
    timelineSection.addEventListener('click', stopAutoPlay);
    timelineSection.addEventListener('keydown', stopAutoPlay);
});

// Contact Page Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Contact form validation (client-side for better UX)
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            // Basic form validation before submission
            const firstName = document.getElementById('first-name');
            const lastName = document.getElementById('last-name');
            const email = document.getElementById('email');
            const message = document.getElementById('message');
            const termsCheckbox = document.getElementById('terms-checkbox');
            
            let isValid = true;
            
            // Clear previous error states
            clearErrors();
            
            // Validate first name
            if (!firstName.value.trim()) {
                showError(firstName, 'First name is required');
                isValid = false;
            }
            
            // Validate last name
            if (!lastName.value.trim()) {
                showError(lastName, 'Last name is required');
                isValid = false;
            }
            
            // Validate email
            if (!email.value.trim()) {
                showError(email, 'Email is required');
                isValid = false;
            } else if (!isValidEmail(email.value)) {
                showError(email, 'Please enter a valid email address');
                isValid = false;
            }
            
            // Validate message
            if (!message.value.trim()) {
                showError(message, 'Message is required');
                isValid = false;
            }
            
            // Validate terms checkbox
            if (!termsCheckbox.checked) {
                showError(termsCheckbox, 'You must accept the terms and conditions');
                isValid = false;
            }
            
            // If validation fails, prevent form submission
            if (!isValid) {
                e.preventDefault();
            }
            // If validation passes, let the form submit to process-contact.php
        });
    }
    
    // Floating icons functionality
    const chatIcon = document.querySelector('.chat-icon');
    const privacyIcon = document.querySelector('.privacy-icon');
    
    if (chatIcon) {
        chatIcon.addEventListener('click', function() {
            alert('Chat support will be available soon!');
        });
    }
    
    if (privacyIcon) {
        privacyIcon.addEventListener('click', function() {
            // Scroll to terms section
            const termsSection = document.querySelector('.terms-container');
            if (termsSection) {
                termsSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
});

// Helper functions for form validation
function showError(element, message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    errorDiv.style.color = '#d32f2f';
    errorDiv.style.fontSize = '0.8rem';
    errorDiv.style.marginTop = '0.25rem';
    
    element.parentNode.appendChild(errorDiv);
    element.style.borderColor = '#d32f2f';
}

function clearErrors() {
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(error => error.remove());
    
    const inputs = document.querySelectorAll('.contact-form input, .contact-form textarea');
    inputs.forEach(input => {
        input.style.borderColor = '#ddd';
    });
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showSuccessMessage() {
    const successDiv = document.createElement('div');
    successDiv.className = 'success-message';
    successDiv.textContent = 'Thank you! Your message has been sent successfully.';
    successDiv.style.backgroundColor = '#4caf50';
    successDiv.style.color = 'white';
    successDiv.style.padding = '1rem';
    successDiv.style.borderRadius = '6px';
    successDiv.style.marginTop = '1rem';
    successDiv.style.textAlign = 'center';
    
    const form = document.querySelector('.contact-form');
    form.appendChild(successDiv);
    
    // Remove success message after 5 seconds
    setTimeout(() => {
        successDiv.remove();
    }, 5000);
}

// Animate 'MEET LEADERSHIP TEAM' header on management page
if (document.querySelector('.team-header h2')) {
    const teamHeader = document.querySelector('.team-header h2');
    teamHeader.style.opacity = '0';
    teamHeader.style.transform = 'translateY(40px)';
    setTimeout(() => {
        teamHeader.style.transition = 'opacity 0.8s cubic-bezier(.77,0,.18,1), transform 0.8s cubic-bezier(.77,0,.18,1)';
        teamHeader.style.opacity = '1';
        teamHeader.style.transform = 'translateY(0)';
    }, 300);
}

// Animate 'MEET SENTINEL' header on core team page
if (document.querySelector('.core-team-header h2')) {
    const coreHeader = document.querySelector('.core-team-header h2');
    coreHeader.style.opacity = '0';
    coreHeader.style.transform = 'translateY(40px)';
    setTimeout(() => {
        coreHeader.style.transition = 'opacity 0.8s cubic-bezier(.77,0,.18,1), transform 0.8s cubic-bezier(.77,0,.18,1)';
        coreHeader.style.opacity = '1';
        coreHeader.style.transform = 'translateY(0)';
    }, 300);
}

// Animate 'MEET THE DEPARTMENTS' header on core team page
if (document.querySelector('.departments-header h2')) {
    const deptHeader = document.querySelector('.departments-header h2');
    deptHeader.style.opacity = '0';
    deptHeader.style.transform = 'translateY(40px)';
    setTimeout(() => {
        deptHeader.style.transition = 'opacity 0.8s cubic-bezier(.77,0,.18,1), transform 0.8s cubic-bezier(.77,0,.18,1)';
        deptHeader.style.opacity = '1';
        deptHeader.style.transform = 'translateY(0)';
    }, 300);
}