// Reveal block modal
(function() {

	// Initialize login modal
	var modalEl = document.querySelector('.modal'),
	revealer = new RevealFx(modalEl),
	openRegisterCtrl = modalEl.querySelector('.btn--modal-register'),
    closeCtrl = document.querySelector('.overlay');
    var primaryColor = '#6AC8EE';
    var darkColor = '#f679e7';

	//Initialize register modalEl
	var modalElRegister = document.querySelector('.modal-register'),
	revealerRegister = new RevealFx(modalElRegister),
	closeRegisterCtrl = document.querySelector('.overlay');

	// Open modal login form
	document.querySelector('.btn--modal-open').addEventListener('click', function() {
		modalEl.classList.add('modal--open');
        $('.overlay').addClass('overlay-show');
        
        console.log('click');
        

		revealer.reveal({
			bgcolor: primaryColor,
			direction: 'tb',
			duration: 400,
			easing: 'easeOutCirc',
			onCover: function(contentEl, revealerEl) {
				contentEl.style.opacity = 1;
			},
			onComplete: function() {
				closeCtrl.addEventListener('click', closeModal); // Cancel and close modal
				openRegisterCtrl.addEventListener('click', openRegister); // close login form and open register form
			}
		});
	});

	// Open modal register form
	function openRegister(ev) {
		// Close login form
		closeCtrl.removeEventListener('click', closeModal);
		openRegisterCtrl.removeEventListener('click', openRegister);
		modalEl.classList.remove('modal--open');
		$('.overlay').addClass('overlay-show');

		revealer.reveal({
			bgcolor: ev.target.classList.contains('btn--modal-close') ? primaryColor : darkColor,
			direction: 'bt',
			duration: ev.target.classList.contains('btn--modal-close') ? 200 : 400,
			easing: 'easeOutCirc',
			onCover: function(contentEl, revealerEl) {
				contentEl.style.opacity = 0;
			},
			onComplete: function() {
				modalEl.classList.remove('modal--open');
			}
		});
		// Open register form
		modalElRegister.classList.add('modal--open');
		revealerRegister.reveal({
			bgcolor: primaryColor,
			direction: 'tb',
			duration: 400,
			easing: 'easeOutCirc',
			onCover: function(contentEl, revealerElRegister) {
				contentEl.style.opacity = 1;
			},
			onComplete: function() {
				closeRegisterCtrl.addEventListener('click', closeModalRegister);
			}
		});
	}

	// Close form and cancel action
	function closeModal(ev) {
		$('.overlay').removeClass('overlay-show');
		closeCtrl.removeEventListener('click', closeModal);
		modalEl.classList.remove('modal--open');

		revealer.reveal({
			bgcolor: ev.target.classList.contains('btn--modal-close') ? primaryColor : darkColor,
			direction: 'bt',
			duration: ev.target.classList.contains('btn--modal-close') ? 200 : 400,
			easing: 'easeOutCirc',
			onCover: function(contentEl, revealerEl) {
				contentEl.style.opacity = 0;
			},
			onComplete: function() {
				modalEl.classList.remove('modal--open');
			}
		});
	}

	// Close form and cancel action
	function closeModalRegister(ev) {
		$('.overlay').removeClass('overlay-show'); // remove mask
		closeRegisterCtrl.removeEventListener('click', closeModalRegister);
		modalElRegister.classList.remove('modal--open');

		revealerRegister.reveal({
			bgcolor: ev.target.classList.contains('btn--modal-close') ? primaryColor : darkColor,
			direction: 'bt',
			duration: ev.target.classList.contains('btn--modal-close') ? 200 : 400,
			easing: 'easeOutCirc',
			onCover: function(contentEl, revealerElRegister) {
				contentEl.style.opacity = 0;
			},
			onComplete: function() {
				modalElRegister.classList.remove('modal--open');
			}
		});
	}

})();
