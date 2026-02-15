/**
 * Toni Janis - Main JavaScript
 * 1:1 from demo/index.html with WordPress compatibility (null checks)
 *
 * @package ToniJanis
 */

document.addEventListener('DOMContentLoaded', function() {

    // ============ HEADER SCROLL EFFECT ============
    const header = document.querySelector('header');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

    // ============ SMOOTH SCROLL FOR ANCHOR LINKS ============
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const targetId = anchor.getAttribute('href');
            if (targetId === '#') return;

            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                const headerHeight = header ? header.offsetHeight : 0;
                const targetPosition = target.getBoundingClientRect().top + window.scrollY - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });

                // Close mobile menu if open
                const mobileMenu = document.querySelector('.mobile-menu');
                const toggle = document.querySelector('.mobile-menu-toggle');
                if (mobileMenu && mobileMenu.classList.contains('active')) {
                    mobileMenu.classList.remove('active');
                    if (toggle) toggle.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }
        });
    });

    // ============ FADE IN ANIMATION ON SCROLL ============
    const fadeElements = document.querySelectorAll('.service-card, .testimonial-card, .gallery-item');

    if (fadeElements.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        fadeElements.forEach(el => {
            el.classList.add('fade-in');
            observer.observe(el);
        });
    }

    // ============ CALENDAR FUNCTIONALITY ============
    const calendarGrid = document.querySelector('.calendar-grid');
    const currentMonthLabel = document.getElementById('currentMonth');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');

    if (calendarGrid && currentMonthLabel) {
        let currentDate = new Date();
        let selectedDate = null;
        let selectedTime = null;

        const months = ['Januar', 'Februar', 'Marz', 'April', 'Mai', 'Juni',
                       'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];

        function renderCalendar() {
            const grid = calendarGrid;
            const monthLabel = currentMonthLabel;

            // Clear previous days (keep headers)
            const headers = Array.from(grid.querySelectorAll('.cal-day-header'));
            grid.innerHTML = '';
            headers.forEach(h => grid.appendChild(h));

            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            monthLabel.textContent = `${months[month]} ${year}`;

            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startingDay = (firstDay.getDay() + 6) % 7; // Monday = 0

            // Empty cells before first day
            for (let i = 0; i < startingDay; i++) {
                const empty = document.createElement('div');
                empty.className = 'cal-day empty';
                grid.appendChild(empty);
            }

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            // Days of month
            for (let day = 1; day <= lastDay.getDate(); day++) {
                const dayEl = document.createElement('div');
                dayEl.className = 'cal-day';
                dayEl.textContent = day;

                const thisDate = new Date(year, month, day);

                if (thisDate < today) {
                    dayEl.classList.add('disabled');
                } else {
                    // Check if it's Sunday (0)
                    if (thisDate.getDay() === 0) {
                        dayEl.classList.add('disabled');
                    } else {
                        dayEl.addEventListener('click', () => selectDate(thisDate, dayEl));
                    }
                }

                if (thisDate.getTime() === today.getTime()) {
                    dayEl.classList.add('today');
                }

                if (selectedDate && thisDate.getTime() === selectedDate.getTime()) {
                    dayEl.classList.add('selected');
                }

                grid.appendChild(dayEl);
            }
        }

        function selectDate(date, element) {
            selectedDate = date;
            selectedTime = null;

            // Update UI
            document.querySelectorAll('.cal-day').forEach(d => d.classList.remove('selected'));
            element.classList.add('selected');

            document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));

            const timeSlotsEl = document.getElementById('timeSlots');
            const bookingSummaryEl = document.getElementById('bookingSummary');
            if (timeSlotsEl) timeSlotsEl.style.display = 'block';
            if (bookingSummaryEl) bookingSummaryEl.style.display = 'none';
        }

        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.addEventListener('click', function() {
                selectedTime = this.dataset.time;

                document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
                this.classList.add('selected');

                // Show summary
                const summary = document.getElementById('bookingSummary');
                const dateStr = `${selectedDate.getDate()}. ${months[selectedDate.getMonth()]} ${selectedDate.getFullYear()}`;
                const selectedDateTimeEl = document.getElementById('selectedDateTime');
                if (selectedDateTimeEl) {
                    selectedDateTimeEl.textContent = `${dateStr} um ${selectedTime} Uhr`;
                }
                if (summary) summary.style.display = 'block';
            });
        });

        if (prevMonthBtn) {
            prevMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });
        }

        if (nextMonthBtn) {
            nextMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });
        }

        const confirmBookingBtn = document.getElementById('confirmBooking');
        if (confirmBookingBtn) {
            confirmBookingBtn.addEventListener('click', () => {
                if (selectedDate && selectedTime) {
                    const dateStr = `${selectedDate.getDate()}. ${months[selectedDate.getMonth()]} ${selectedDate.getFullYear()}`;
                    alert(`Termin gebucht!\n\nDatum: ${dateStr}\nUhrzeit: ${selectedTime} Uhr\n\nWir werden Sie zur Bestatigung kontaktieren.`);
                }
            });
        }

        // Initialize calendar
        renderCalendar();
    }

    // ============ BEFORE/AFTER SLIDER FUNCTIONALITY ============
    const baComparison = document.getElementById('baMainComparison');
    const baSlider = document.getElementById('baSlider');
    const baBeforeImage = document.getElementById('baBeforeImage');
    const baAfterImage = document.getElementById('baAfterImage');
    const baProjectTitle = document.getElementById('baProjectTitle');
    const baProjectDescription = document.getElementById('baProjectDescription');
    const baProjectTags = document.getElementById('baProjectTags');
    const baPrevBtn = document.getElementById('baPrev');
    const baNextBtn = document.getElementById('baNext');
    const baDotsContainer = document.getElementById('baDots');

    if (baComparison && baSlider && baBeforeImage && baAfterImage) {
        const baProjects = [
            {
                title: 'Komplette Gartenumgestaltung',
                description: 'Verwandlung eines verwilderten Gartens in eine moderne Wohlfuhloase mit Terrasse, Rasenflache und mediterraner Bepflanzung.',
                tags: ['Gartengestaltung', 'Rollrasen', 'Pflasterung'],
                beforeBg: 'linear-gradient(135deg, #8B7355 0%, #A0826D 100%)',
                afterBg: 'linear-gradient(135deg, #4A7C59 0%, #7CB342 100%)'
            },
            {
                title: 'Terrassen-Neuanlage',
                description: 'Aus einem alten Betonplatz wurde eine elegante Naturstein-Terrasse mit integrierter Beleuchtung und Hochbeeten.',
                tags: ['Pflasterarbeiten', 'Beleuchtung'],
                beforeBg: 'linear-gradient(135deg, #696969 0%, #808080 100%)',
                afterBg: 'linear-gradient(135deg, #2E5A3C 0%, #4A7C59 100%)'
            },
            {
                title: 'Vorgarten-Modernisierung',
                description: 'Neugestaltung eines Vorgartens mit pflegeleichter Bepflanzung, Zierkies und modernem Wegesystem.',
                tags: ['Vorgarten', 'Pflegeleicht', 'Modern'],
                beforeBg: 'linear-gradient(135deg, #654321 0%, #8B6914 100%)',
                afterBg: 'linear-gradient(135deg, #228B22 0%, #32CD32 100%)'
            }
        ];

        let currentBAIndex = 0;

        function updateBAProject(index) {
            const project = baProjects[index];

            baBeforeImage.style.background = project.beforeBg;
            baAfterImage.style.background = project.afterBg;

            if (baProjectTitle) baProjectTitle.textContent = project.title;
            if (baProjectDescription) baProjectDescription.textContent = project.description;

            if (baProjectTags) {
                baProjectTags.innerHTML = project.tags.map(tag =>
                    `<span class="ba-tag">${tag}</span>`
                ).join('');
            }

            document.querySelectorAll('.ba-dot').forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });

            if (baPrevBtn) baPrevBtn.disabled = index === 0;
            if (baNextBtn) baNextBtn.disabled = index === baProjects.length - 1;
        }

        function initBADots() {
            if (!baDotsContainer) return;
            baDotsContainer.innerHTML = baProjects.map((_, i) =>
                `<div class="ba-dot ${i === 0 ? 'active' : ''}" data-index="${i}"></div>`
            ).join('');

            document.querySelectorAll('.ba-dot').forEach(dot => {
                dot.addEventListener('click', () => {
                    currentBAIndex = parseInt(dot.dataset.index);
                    updateBAProject(currentBAIndex);
                });
            });
        }

        if (baPrevBtn) {
            baPrevBtn.addEventListener('click', () => {
                if (currentBAIndex > 0) {
                    currentBAIndex--;
                    updateBAProject(currentBAIndex);
                }
            });
        }

        if (baNextBtn) {
            baNextBtn.addEventListener('click', () => {
                if (currentBAIndex < baProjects.length - 1) {
                    currentBAIndex++;
                    updateBAProject(currentBAIndex);
                }
            });
        }

        // Slider drag functionality
        let isDragging = false;

        function updateSliderPosition(x) {
            const rect = baComparison.getBoundingClientRect();
            const position = Math.max(0, Math.min(x - rect.left, rect.width));
            const percentage = (position / rect.width) * 100;

            baSlider.style.left = percentage + '%';
            baAfterImage.style.clipPath = `inset(0 ${100 - percentage}% 0 0)`;
        }

        baSlider.addEventListener('mousedown', () => { isDragging = true; });
        document.addEventListener('mousemove', (e) => { if (isDragging) updateSliderPosition(e.clientX); });
        document.addEventListener('mouseup', () => { isDragging = false; });

        baSlider.addEventListener('touchstart', (e) => { e.preventDefault(); isDragging = true; });
        document.addEventListener('touchmove', (e) => { if (isDragging) updateSliderPosition(e.touches[0].clientX); });
        document.addEventListener('touchend', () => { isDragging = false; });

        baComparison.addEventListener('click', (e) => {
            if (e.target === baSlider || e.target.parentElement === baSlider) return;
            updateSliderPosition(e.clientX);
        });

        initBADots();
        updateBAProject(currentBAIndex);
    }

    // ============ JOB ACCORDION FUNCTIONALITY ============
    function toggleJobCard(headerElement) {
        const card = headerElement.closest('.job-card');
        if (!card) return;
        const content = card.querySelector('.job-content');
        const button = card.querySelector('.job-toggle-btn');

        if (button) button.classList.toggle('active');
        if (content) content.classList.toggle('active');
    }
    window.toggleJobCard = toggleJobCard;

    // ============ IMAGE UPLOAD FUNCTIONALITY ============
    const uploadArea = document.getElementById('uploadArea');
    const uploadInput = document.getElementById('projectPhotos');
    const previewGrid = document.getElementById('imagePreviewGrid');
    const uploadCountEl = document.getElementById('uploadCount');

    if (uploadArea && uploadInput) {
        let uploadedFiles = [];
        const MAX_FILES = 10;
        const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('drag-over');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('drag-over');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');
            handleFiles(Array.from(e.dataTransfer.files));
        });

        uploadInput.addEventListener('change', (e) => {
            handleFiles(Array.from(e.target.files));
        });

        function handleFiles(files) {
            const validFiles = files.filter(file => {
                if (!file.type.startsWith('image/')) {
                    alert(`${file.name} ist keine Bilddatei`);
                    return false;
                }
                if (file.size > MAX_FILE_SIZE) {
                    alert(`${file.name} ist zu gross (max. 5MB)`);
                    return false;
                }
                return true;
            });

            if (uploadedFiles.length + validFiles.length > MAX_FILES) {
                alert(`Sie konnen maximal ${MAX_FILES} Bilder hochladen`);
                return;
            }

            validFiles.forEach(file => {
                uploadedFiles.push(file);
                displayPreview(file);
            });

            updateUploadCount();
        }

        function displayPreview(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.dataset.filename = file.name;
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="${file.name}" class="preview-image">
                    <button class="preview-remove" onclick="removeImage('${file.name}')" type="button">&times;</button>
                    <div class="preview-filename">${file.name}</div>
                `;
                if (previewGrid) previewGrid.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        }

        function removeImage(filename) {
            uploadedFiles = uploadedFiles.filter(file => file.name !== filename);
            const previewItem = document.querySelector(`[data-filename="${filename}"]`);
            if (previewItem) previewItem.remove();
            updateUploadCount();
        }

        function updateUploadCount() {
            if (!uploadCountEl) return;
            if (uploadedFiles.length > 0) {
                uploadCountEl.innerHTML = `<span class="upload-count">${uploadedFiles.length} ${uploadedFiles.length === 1 ? 'Bild' : 'Bilder'} hochgeladen</span>`;
            } else {
                uploadCountEl.innerHTML = '';
            }
        }

        window.removeImage = removeImage;
    }

    // ============ ENTSORGEN IMAGE UPLOAD WITH QUALITY CHECK ============
    const entsorgenUploadArea = document.getElementById('entsorgenUploadArea');
    const entsorgenInput = document.getElementById('entsorgenPhotos');
    const entsorgenPreviewGrid = document.getElementById('entsorgenPreviewGrid');
    const entsorgenUploadCountEl = document.getElementById('entsorgenUploadCount');
    const qualityWarningEl = document.getElementById('qualityWarning');

    if (entsorgenUploadArea && entsorgenInput) {
        let entsorgenFiles = [];
        const MIN_ENTSORGEN_FILES = 3;
        const MAX_ENTSORGEN_FILES = 5;
        const MIN_FILE_SIZE = 200 * 1024;
        const MIN_WIDTH = 800;
        const MIN_HEIGHT = 600;

        entsorgenUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            entsorgenUploadArea.classList.add('drag-over');
        });

        entsorgenUploadArea.addEventListener('dragleave', () => {
            entsorgenUploadArea.classList.remove('drag-over');
        });

        entsorgenUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            entsorgenUploadArea.classList.remove('drag-over');
            handleEntsorgenFiles(Array.from(e.dataTransfer.files));
        });

        entsorgenInput.addEventListener('change', (e) => {
            handleEntsorgenFiles(Array.from(e.target.files));
        });

        async function handleEntsorgenFiles(files) {
            if (qualityWarningEl) {
                qualityWarningEl.style.display = 'none';
                qualityWarningEl.className = 'quality-warning';
            }

            if (entsorgenFiles.length + files.length > MAX_ENTSORGEN_FILES) {
                showQualityWarning(`Sie konnen maximal ${MAX_ENTSORGEN_FILES} Bilder hochladen`, 'error');
                return;
            }

            for (const file of files) {
                if (!file.type.startsWith('image/')) {
                    showQualityWarning(`${file.name} ist keine Bilddatei`, 'error');
                    continue;
                }

                if (file.size < MIN_FILE_SIZE) {
                    showQualityWarning(`${file.name} ist zu klein (min. 200KB). Bitte hochwertigere Bilder hochladen.`, 'error');
                    continue;
                }

                const dimensions = await checkImageDimensions(file);
                if (!dimensions) {
                    showQualityWarning(`${file.name} konnte nicht geladen werden`, 'error');
                    continue;
                }

                if (dimensions.width < MIN_WIDTH || dimensions.height < MIN_HEIGHT) {
                    showQualityWarning(
                        `${file.name} hat eine zu niedrige Auflosung (${dimensions.width}x${dimensions.height}). Mindestens ${MIN_WIDTH}x${MIN_HEIGHT} erforderlich.`,
                        'error'
                    );
                    continue;
                }

                const qualityRatio = file.size / (dimensions.width * dimensions.height);
                if (qualityRatio < 0.1) {
                    showQualityWarning(
                        `${file.name} scheint zu stark komprimiert oder von geringer Qualitat zu sein.`,
                        'error'
                    );
                    continue;
                }

                entsorgenFiles.push(file);
                displayEntsorgenPreview(file, dimensions);
            }

            updateEntsorgenCount();
        }

        function checkImageDimensions(file) {
            return new Promise((resolve) => {
                const img = new Image();
                const url = URL.createObjectURL(file);
                img.onload = () => { URL.revokeObjectURL(url); resolve({ width: img.width, height: img.height }); };
                img.onerror = () => { URL.revokeObjectURL(url); resolve(null); };
                img.src = url;
            });
        }

        function displayEntsorgenPreview(file, dimensions) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.dataset.filename = file.name;
                const sizeKB = Math.round(file.size / 1024);
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="${file.name}" class="preview-image">
                    <button class="preview-remove" onclick="removeEntsorgenImage('${file.name}')" type="button">&times;</button>
                    <div class="preview-filename">${file.name} (${sizeKB}KB - ${dimensions.width}x${dimensions.height})</div>
                `;
                if (entsorgenPreviewGrid) entsorgenPreviewGrid.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        }

        function removeEntsorgenImage(filename) {
            entsorgenFiles = entsorgenFiles.filter(file => file.name !== filename);
            if (entsorgenPreviewGrid) {
                const previewItem = entsorgenPreviewGrid.querySelector(`[data-filename="${filename}"]`);
                if (previewItem) previewItem.remove();
            }
            updateEntsorgenCount();
        }

        function updateEntsorgenCount() {
            if (!entsorgenUploadCountEl) return;
            if (entsorgenFiles.length > 0) {
                const remaining = MAX_ENTSORGEN_FILES - entsorgenFiles.length;
                let countText = `<span class="upload-count">${entsorgenFiles.length} ${entsorgenFiles.length === 1 ? 'Bild' : 'Bilder'} hochgeladen</span>`;

                if (entsorgenFiles.length < MIN_ENTSORGEN_FILES) {
                    countText += ` <span style="color: #ff9800; margin-left: 0.5rem;">(Noch ${MIN_ENTSORGEN_FILES - entsorgenFiles.length} erforderlich)</span>`;
                } else if (remaining > 0) {
                    countText += ` <span style="color: #4caf50; margin-left: 0.5rem;">(Noch ${remaining} moglich)</span>`;
                } else {
                    countText += ` <span style="color: #4caf50; margin-left: 0.5rem;">(Maximum erreicht)</span>`;
                }

                entsorgenUploadCountEl.innerHTML = countText;

                if (entsorgenFiles.length >= MIN_ENTSORGEN_FILES) {
                    showQualityWarning(`Perfekt! Sie haben ${entsorgenFiles.length} qualitativ hochwertige Bilder hochgeladen.`, 'success');
                }
            } else {
                entsorgenUploadCountEl.innerHTML = '';
            }
        }

        function showQualityWarning(message, type) {
            if (!qualityWarningEl) return;
            qualityWarningEl.textContent = message;
            qualityWarningEl.className = `quality-warning ${type || 'error'}`;
            qualityWarningEl.style.display = 'block';
        }

        const entsorgenForm = document.getElementById('entsorgenForm');
        if (entsorgenForm) {
            entsorgenForm.addEventListener('submit', (e) => {
                e.preventDefault();

                if (entsorgenFiles.length < MIN_ENTSORGEN_FILES) {
                    showQualityWarning(`Bitte laden Sie mindestens ${MIN_ENTSORGEN_FILES} qualitativ hochwertige Bilder hoch.`, 'error');
                    window.scrollTo({ top: entsorgenUploadArea.offsetTop - 100, behavior: 'smooth' });
                    return;
                }

                showQualityWarning('Vielen Dank! Ihre Anfrage wird verarbeitet. Wir melden uns innerhalb von 24 Stunden bei Ihnen.', 'success');

                setTimeout(() => {
                    alert('Anfrage erfolgreich gesendet!\n\nWir haben Ihre Entsorgungsanfrage mit ' + entsorgenFiles.length + ' Bildern erhalten.\n\nSie erhalten innerhalb von 24 Stunden ein kostenloses Angebot von uns.');
                    entsorgenForm.reset();
                    entsorgenFiles = [];
                    if (entsorgenPreviewGrid) entsorgenPreviewGrid.innerHTML = '';
                    updateEntsorgenCount();
                    if (qualityWarningEl) qualityWarningEl.style.display = 'none';
                }, 1000);
            });
        }

        window.removeEntsorgenImage = removeEntsorgenImage;
    }

    // ============ SLIDER CLASS (Gallery + Testimonials) ============
    class Slider {
        constructor(wrapperId, prevBtnId, nextBtnId, dotsId, options = {}) {
            this.wrapper = document.getElementById(wrapperId);
            this.prevBtn = document.getElementById(prevBtnId);
            this.nextBtn = document.getElementById(nextBtnId);
            this.dotsContainer = document.getElementById(dotsId);

            if (!this.wrapper) return;

            this.slides = this.wrapper.children;
            this.currentIndex = 0;
            this.autoPlay = options.autoPlay || false;
            this.autoPlayInterval = options.autoPlayInterval || 5000;
            this.autoPlayTimer = null;

            this.init();
        }

        init() {
            this.createDots();
            this.updateSlider();

            if (this.prevBtn) {
                this.prevBtn.addEventListener('click', () => this.prev());
            }
            if (this.nextBtn) {
                this.nextBtn.addEventListener('click', () => this.next());
            }

            this.addTouchSupport();

            if (this.autoPlay) {
                this.startAutoPlay();
                this.wrapper.parentElement.addEventListener('mouseenter', () => this.stopAutoPlay());
                this.wrapper.parentElement.addEventListener('mouseleave', () => this.startAutoPlay());
            }
        }

        createDots() {
            if (!this.dotsContainer) return;

            this.dotsContainer.innerHTML = '';
            for (let i = 0; i < this.slides.length; i++) {
                const dot = document.createElement('div');
                dot.className = 'slider-dot';
                if (i === 0) dot.classList.add('active');
                dot.addEventListener('click', () => this.goToSlide(i));
                this.dotsContainer.appendChild(dot);
            }
        }

        updateSlider() {
            const translateX = -this.currentIndex * 100;
            this.wrapper.style.transform = `translateX(${translateX}%)`;

            if (this.dotsContainer) {
                const dots = this.dotsContainer.children;
                for (let i = 0; i < dots.length; i++) {
                    dots[i].classList.toggle('active', i === this.currentIndex);
                }
            }

            if (this.prevBtn) {
                this.prevBtn.disabled = this.currentIndex === 0;
            }
            if (this.nextBtn) {
                this.nextBtn.disabled = this.currentIndex === this.slides.length - 1;
            }
        }

        next() {
            if (this.currentIndex < this.slides.length - 1) {
                this.currentIndex++;
                this.updateSlider();
            } else if (this.autoPlay) {
                this.currentIndex = 0;
                this.updateSlider();
            }
        }

        prev() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
                this.updateSlider();
            }
        }

        goToSlide(index) {
            this.currentIndex = index;
            this.updateSlider();
        }

        addTouchSupport() {
            let touchStartX = 0;
            let touchEndX = 0;

            this.wrapper.parentElement.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });

            this.wrapper.parentElement.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                if (touchEndX < touchStartX - 50) this.next();
                if (touchEndX > touchStartX + 50) this.prev();
            });
        }

        startAutoPlay() {
            if (this.autoPlay) {
                this.stopAutoPlay();
                this.autoPlayTimer = setInterval(() => this.next(), this.autoPlayInterval);
            }
        }

        stopAutoPlay() {
            if (this.autoPlayTimer) {
                clearInterval(this.autoPlayTimer);
                this.autoPlayTimer = null;
            }
        }
    }

    // Initialize sliders
    new Slider('gallerySliderWrapper', 'galleryPrev', 'galleryNext', 'galleryDots',
        { autoPlay: true, autoPlayInterval: 6000 });

    new Slider('testimonialsSliderWrapper', 'testimonialsPrev', 'testimonialsNext', 'testimonialsDots',
        { autoPlay: true, autoPlayInterval: 7000 });

    // ============ PROJECTS FILTER FUNCTIONALITY ============
    const filterBtns = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card');

    if (filterBtns.length) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.dataset.filter;

                projectCards.forEach(card => {
                    if (filter === 'alle') {
                        card.classList.remove('hidden');
                    } else {
                        if (card.dataset.category === filter) {
                            card.classList.remove('hidden');
                        } else {
                            card.classList.add('hidden');
                        }
                    }
                });
            });
        });
    }

    // ============ FAQ ACCORDION FUNCTIONALITY ============
    const faqItems = document.querySelectorAll('.faq-item');

    if (faqItems.length) {
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            if (!question) return;

            question.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                faqItems.forEach(faq => faq.classList.remove('active'));
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });
    }

    // ============ QUOTE FORM STEPPER ============
    let currentQuoteStep = 1;

    function nextQuoteStep(step) {
        const currentEl = document.querySelector(`#quoteStep${currentQuoteStep}`);
        const currentProgress = document.querySelector(`.progress-step[data-step="${currentQuoteStep}"]`);
        if (currentEl) currentEl.classList.remove('active');
        if (currentProgress) {
            currentProgress.classList.remove('active');
            currentProgress.classList.add('completed');
        }

        currentQuoteStep = step;

        const nextEl = document.querySelector(`#quoteStep${step}`);
        const nextProgress = document.querySelector(`.progress-step[data-step="${step}"]`);
        if (nextEl) nextEl.classList.add('active');
        if (nextProgress) nextProgress.classList.add('active');
    }

    function prevQuoteStep(step) {
        const currentEl = document.querySelector(`#quoteStep${currentQuoteStep}`);
        const currentProgress = document.querySelector(`.progress-step[data-step="${currentQuoteStep}"]`);
        if (currentEl) currentEl.classList.remove('active');
        if (currentProgress) currentProgress.classList.remove('active');

        currentQuoteStep = step;

        const prevEl = document.querySelector(`#quoteStep${step}`);
        const prevProgress = document.querySelector(`.progress-step[data-step="${step}"]`);
        if (prevEl) prevEl.classList.add('active');
        if (prevProgress) {
            prevProgress.classList.remove('completed');
            prevProgress.classList.add('active');
        }
    }

    function submitQuote() {
        const firstName = document.getElementById('quoteFirstName');
        const lastName = document.getElementById('quoteLastName');
        const email = document.getElementById('quoteEmail');
        const phone = document.getElementById('quotePhone');
        const privacy = document.getElementById('quotePrivacy');

        if (!firstName?.value || !lastName?.value || !email?.value || !phone?.value || !privacy?.checked) {
            alert('Bitte fullen Sie alle Pflichtfelder aus.');
            return;
        }

        const step3 = document.querySelector(`#quoteStep3`);
        const success = document.querySelector('#quoteSuccess');
        if (step3) step3.classList.remove('active');
        if (success) success.classList.add('active');

        document.querySelectorAll('.progress-step').forEach(s => {
            s.classList.remove('active');
            s.classList.add('completed');
        });
    }

    function resetQuote() {
        currentQuoteStep = 1;

        document.querySelectorAll('.quote-step').forEach(s => s.classList.remove('active'));
        const step1 = document.querySelector('#quoteStep1');
        if (step1) step1.classList.add('active');

        document.querySelectorAll('.progress-step').forEach(s => {
            s.classList.remove('active', 'completed');
        });
        const firstProgress = document.querySelector('.progress-step[data-step="1"]');
        if (firstProgress) firstProgress.classList.add('active');

        document.querySelectorAll('.service-option input').forEach(i => i.checked = false);
        document.querySelectorAll('.details-form input, .details-form textarea, .details-form select').forEach(i => {
            if (i.type === 'checkbox') i.checked = false;
            else i.value = '';
        });
    }

    window.nextQuoteStep = nextQuoteStep;
    window.prevQuoteStep = prevQuoteStep;
    window.submitQuote = submitQuote;
    window.resetQuote = resetQuote;

    // ============ SERVICE DETAIL MODAL ============
    const serviceModal = document.createElement('div');
    serviceModal.className = 'service-modal';
    serviceModal.id = 'serviceModal';
    document.body.appendChild(serviceModal);

    const servicesData = {
        gartengestaltung: {
            icon: '🌳', title: 'Gartengestaltung',
            description: 'Kreative Planung und professionelle Umsetzung Ihrer individuellen Gartentraume',
            features: [
                { icon: '📐', title: 'Individuelle Planung', text: 'Massgeschneiderte Konzepte nach Ihren Wunschen und den ortlichen Gegebenheiten' },
                { icon: '🎨', title: 'Kreatives Design', text: 'Moderne und zeitlose Gartengestaltung mit Stil' },
                { icon: '🌱', title: 'Bepflanzung', text: 'Auswahl passender Pflanzen fur jeden Standort' },
                { icon: '💧', title: 'Bewasserung', text: 'Automatische Bewasserungssysteme auf Wunsch' }
            ],
            pricing: [
                { label: 'Basis', value: '50-80\u20AC/m\u00B2' },
                { label: 'Standard', value: '80-150\u20AC/m\u00B2' },
                { label: 'Premium', value: '150-300\u20AC/m\u00B2' }
            ]
        },
        gartenpflege: {
            icon: '🌿', title: 'Gartenpflege',
            description: 'Regelmassige professionelle Pflege fur einen dauerhaft gepflegten Garten',
            features: [
                { icon: '✂️', title: 'Rasenpflege', text: 'Mahen, Vertikutieren, Dungen fur perfekten Rasen' },
                { icon: '🌳', title: 'Hecken & Straucher', text: 'Fachgerechter Schnitt zur richtigen Jahreszeit' },
                { icon: '🗓️', title: 'Abo-Service', text: 'Regelmassige Pflege nach festem Zeitplan' },
                { icon: '🍂', title: 'Saisonarbeiten', text: 'Herbstlaub, Winterschutz, Fruhjahrsputz' }
            ],
            pricing: [
                { label: 'Einmalig', value: 'ab 45\u20AC/Std' },
                { label: 'Monatlich', value: 'ab 120\u20AC/Mon' },
                { label: 'Jahresabo', value: 'ab 100\u20AC/Mon' }
            ]
        },
        pflasterung: {
            icon: '🧱', title: 'Pflasterarbeiten',
            description: 'Hochwertige Pflasterarbeiten fur Terrassen, Wege und Einfahrten',
            features: [
                { icon: '🏗️', title: 'Terrassen', text: 'Naturstein, Beton oder Keramikplatten' },
                { icon: '🚗', title: 'Einfahrten', text: 'Belastbare Pflasterung fur Fahrzeuge' },
                { icon: '🛤️', title: 'Gartenwege', text: 'Funktionale und dekorative Wegefuhrung' },
                { icon: '💡', title: 'Beleuchtung', text: 'Integration von LED-Beleuchtung moglich' }
            ],
            pricing: [
                { label: 'Betonstein', value: '60-90\u20AC/m\u00B2' },
                { label: 'Naturstein', value: '90-150\u20AC/m\u00B2' },
                { label: 'Premium', value: '150-250\u20AC/m\u00B2' }
            ]
        },
        rollrasen: {
            icon: '🚜', title: 'Rollrasen verlegen',
            description: 'Sofort gruner Rasen durch professionelle Rollrasenverlegung',
            features: [
                { icon: '🌱', title: 'Premium-Qualitat', text: 'Hochwertige Rasensorten fur jeden Standort' },
                { icon: '⚡', title: 'Schnell nutzbar', text: 'Nach 2-3 Wochen voll belastbar' },
                { icon: '📏', title: 'Bodenvorbereitung', text: 'Professionelle Vorbereitung des Untergrunds' },
                { icon: '💧', title: 'Erstpflege', text: 'Anleitung und Tipps fur optimales Anwachsen' }
            ],
            pricing: [
                { label: 'Basis', value: '15-20\u20AC/m\u00B2' },
                { label: 'Premium', value: '20-30\u20AC/m\u00B2' },
                { label: 'Mit Sprinkler', value: '35-45\u20AC/m\u00B2' }
            ]
        },
        zaunbau: {
            icon: '🏠', title: 'Zaunbau & Sichtschutz',
            description: 'Hochwertige Zaune und Sichtschutzelemente fur mehr Privatsphare',
            features: [
                { icon: '🪵', title: 'Holzzaune', text: 'Naturliche und warme Optik' },
                { icon: '🔧', title: 'Metallzaune', text: 'Robust und pflegeleicht' },
                { icon: '🎋', title: 'Sichtschutz', text: 'Elemente aus Holz, Metall oder Bambus' },
                { icon: '🔒', title: 'Tore & Turen', text: 'Passende Zugangslosungen' }
            ],
            pricing: [
                { label: 'Holz', value: '80-120\u20AC/m' },
                { label: 'Metall', value: '100-180\u20AC/m' },
                { label: 'Kombi', value: '150-250\u20AC/m' }
            ]
        },
        winterdienst: {
            icon: '❄️', title: 'Winterdienst',
            description: 'Zuverlassiger Winterdienst fur sichere Wege und Einfahrten',
            features: [
                { icon: '🚜', title: 'Schneeraumung', text: 'Schnelle Raumung bei Schneefall' },
                { icon: '🧂', title: 'Streudienst', text: 'Professionelles Streuen gegen Glatte' },
                { icon: '📞', title: 'Bereitschaft', text: '24/7 erreichbar wahrend Winterperiode' },
                { icon: '📅', title: 'Vertragsservice', text: 'Saisonvertrage fur Gewerbe und Privat' }
            ],
            pricing: [
                { label: 'Pro Einsatz', value: 'ab 45\u20AC' },
                { label: 'Monat', value: 'ab 150\u20AC/Mon' },
                { label: 'Saison', value: 'ab 500\u20AC' }
            ]
        }
    };

    function openServiceModal(serviceKey) {
        const service = servicesData[serviceKey];
        if (!service) return;

        serviceModal.innerHTML = `
            <div class="service-modal-content">
                <button class="service-modal-close" onclick="closeServiceModal()">&times;</button>
                <div class="service-detail-header">
                    <div class="service-detail-icon">${service.icon}</div>
                    <h2>${service.title}</h2>
                    <p>${service.description}</p>
                </div>
                <div class="service-detail-body">
                    <div class="service-detail-section">
                        <h3>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                                <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
                            </svg>
                            Was wir bieten
                        </h3>
                        <div class="service-features-grid">
                            ${service.features.map(feature => `
                                <div class="service-feature-item">
                                    <div class="service-feature-icon">${feature.icon}</div>
                                    <div class="service-feature-content">
                                        <h4>${feature.title}</h4>
                                        <p>${feature.text}</p>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    <div class="service-detail-section">
                        <div class="service-pricing">
                            <h4>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 6v12M8 10h8M8 14h8"/>
                                </svg>
                                Preisorientierung (inkl. Material)
                            </h4>
                            <div class="pricing-grid">
                                ${service.pricing.map(price => `
                                    <div class="pricing-item">
                                        <div class="pricing-label">${price.label}</div>
                                        <div class="pricing-value">${price.value}</div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        <p style="text-align: center; color: var(--earth-brown); font-size: 0.9rem; margin-top: 1rem;">
                            Die finalen Preise hangen von Ihren individuellen Anforderungen ab. Wir erstellen Ihnen gerne ein kostenloses, unverbindliches Angebot.
                        </p>
                    </div>
                    <div class="service-detail-section">
                        <div class="service-quote-form">
                            <h3>Individuelles Angebot anfordern</h3>
                            <form onsubmit="submitServiceQuote(event, '${serviceKey}')">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Ihr Name *</label>
                                        <input type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Telefon *</label>
                                        <input type="tel" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>E-Mail *</label>
                                        <input type="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label>PLZ & Ort *</label>
                                        <input type="text" placeholder="27755 Delmenhorst" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Projektbeschreibung</label>
                                    <textarea placeholder="Beschreiben Sie Ihr Projekt so detailliert wie moglich..." rows="4"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" style="width: 100%;">
                                    Kostenloses Angebot anfordern
                                    <span>&rarr;</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;

        serviceModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeServiceModal() {
        serviceModal.classList.remove('active');
        document.body.style.overflow = '';
    }

    window.openServiceModal = openServiceModal;
    window.closeServiceModal = closeServiceModal;

    window.submitServiceQuote = function(event, serviceKey) {
        event.preventDefault();
        alert(`Vielen Dank fur Ihre Anfrage fur ${servicesData[serviceKey].title}!\n\nWir werden uns innerhalb von 24 Stunden bei Ihnen melden.`);
        closeServiceModal();
    };

    serviceModal.addEventListener('click', (e) => {
        if (e.target === serviceModal) closeServiceModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && serviceModal.classList.contains('active')) {
            closeServiceModal();
        }
    });

    document.querySelectorAll('.service-link').forEach(link => {
        link.addEventListener('click', (e) => {
            const serviceKey = link.dataset.service;
            if (serviceKey) {
                e.preventDefault();
                openServiceModal(serviceKey);
            }
        });
    });

    // ============ DARK MODE TOGGLE ============
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        const isDarkMode = document.body.classList.contains('dark-mode');
        localStorage.setItem('darkMode', isDarkMode ? 'enabled' : 'disabled');
    }

    // Check for saved dark mode preference
    const darkModePreference = localStorage.getItem('darkMode');
    if (darkModePreference === 'enabled') {
        document.body.classList.add('dark-mode');
    }

    window.toggleDarkMode = toggleDarkMode;

    // ============ MOBILE MENU TOGGLE ============
    function toggleMobileMenu() {
        const mobileMenu = document.querySelector('.mobile-menu');
        const toggle = document.querySelector('.mobile-menu-toggle');
        if (mobileMenu) mobileMenu.classList.toggle('active');
        if (toggle) toggle.classList.toggle('active');
        document.body.style.overflow = (mobileMenu && mobileMenu.classList.contains('active')) ? 'hidden' : '';
    }

    window.toggleMobileMenu = toggleMobileMenu;

    // ============ APPOINTMENT STEPPER NAVIGATION ============
    let appointmentData = {
        consultationType: '', date: '', time: '',
        firstName: '', lastName: '', email: '', phone: ''
    };

    function nextAppointmentStep(stepNumber) {
        document.querySelectorAll('.appointment-step').forEach(step => {
            step.classList.remove('active');
        });

        const targetStep = document.getElementById('appointmentStep' + stepNumber);
        if (targetStep) targetStep.classList.add('active');

        document.querySelectorAll('.appointment-progress .progress-step').forEach((step, index) => {
            if (index + 1 <= stepNumber) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });

        const terminEl = document.getElementById('termin');
        if (terminEl) terminEl.scrollIntoView({ behavior: 'smooth', block: 'start' });

        if (stepNumber === 4) updateAppointmentSummary();
    }

    function updateAppointmentSummary() {
        // Populate summary from collected data
    }

    document.querySelectorAll('input[name="consultation-type"]').forEach(input => {
        input.addEventListener('change', (e) => {
            appointmentData.consultationType = e.target.value;
            setTimeout(() => { nextAppointmentStep(2); }, 500);
        });
    });

    window.nextAppointmentStep = nextAppointmentStep;

    // ============ PARALLAX EFFECT ============
    const heroEl = document.querySelector('.hero');
    if (heroEl) {
        function throttle(func, delay) {
            let lastCall = 0;
            return function(...args) {
                const now = Date.now();
                if (now - lastCall >= delay) {
                    lastCall = now;
                    func(...args);
                }
            };
        }

        function parallaxEffect() {
            const scrolled = window.pageYOffset;
            const heroHeight = heroEl.offsetHeight;

            if (scrolled < heroHeight) {
                const parallaxSpeed = 0.5;
                heroEl.style.backgroundPositionY = `${scrolled * parallaxSpeed}px`;
            }
        }

        window.addEventListener('scroll', throttle(parallaxEffect, 10));
    }

    // ============ CONTACT MODAL FUNCTIONALITY ============
    const contactModal = document.getElementById('contactModal');

    function openContactModal() {
        if (contactModal) {
            contactModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeContactModal() {
        if (contactModal) {
            contactModal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    window.openContactModal = openContactModal;
    window.closeContactModal = closeContactModal;

    if (contactModal) {
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && contactModal.classList.contains('active')) {
                closeContactModal();
            }
        });
    }

    function submitContactForm(event) {
        event.preventDefault();
        alert('Vielen Dank fur Ihre Anfrage! Wir melden uns schnellstmoglich bei Ihnen.');
        closeContactModal();
        event.target.reset();
        resetContactStepper();
    }

    // ============ CONTACT MODAL STEPPER ============
    let currentContactStep = 1;
    const totalContactSteps = 3;

    function updateContactStepper() {
        document.querySelectorAll('.form-step').forEach(step => {
            const stepNumber = parseInt(step.dataset.step);
            step.classList.toggle('active', stepNumber === currentContactStep);
        });

        document.querySelectorAll('.stepper-step').forEach(step => {
            const stepNumber = parseInt(step.dataset.step);
            step.classList.remove('active', 'completed');
            if (stepNumber < currentContactStep) {
                step.classList.add('completed');
            } else if (stepNumber === currentContactStep) {
                step.classList.add('active');
            }
        });

        const prevBtn = document.getElementById('prevStepBtn');
        const nextBtn = document.getElementById('nextStepBtn');
        const submitBtn = document.getElementById('submitStepBtn');

        if (prevBtn) prevBtn.style.display = currentContactStep === 1 ? 'none' : 'block';
        if (nextBtn) nextBtn.style.display = currentContactStep === totalContactSteps ? 'none' : 'block';
        if (submitBtn) submitBtn.style.display = currentContactStep === totalContactSteps ? 'block' : 'none';
    }

    function nextContactStep() {
        const currentStepEl = document.querySelector(`.form-step[data-step="${currentContactStep}"]`);
        if (currentStepEl) {
            const inputs = currentStepEl.querySelectorAll('input[required], textarea[required], select[required]');
            let isValid = true;
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    isValid = false;
                }
            });

            if (currentContactStep === 1) {
                const serviceSelected = document.querySelector('input[name="service"]:checked');
                if (!serviceSelected) {
                    alert('Bitte wahlen Sie eine Leistung aus.');
                    return;
                }
            }

            if (isValid && currentContactStep < totalContactSteps) {
                currentContactStep++;
                updateContactStepper();
            }
        }
    }

    function previousContactStep() {
        if (currentContactStep > 1) {
            currentContactStep--;
            updateContactStepper();
        }
    }

    function resetContactStepper() {
        currentContactStep = 1;
        updateContactStepper();
    }

    window.nextContactStep = nextContactStep;
    window.previousContactStep = previousContactStep;

    const originalOpenContactModal = openContactModal;
    window.openContactModal = function() {
        originalOpenContactModal();
        resetContactStepper();
    };

    window.submitContactForm = submitContactForm;

    // ============ ACCORDION / FAQ FUNCTIONALITY ============
    function toggleAccordion(button) {
        const item = button.closest('.accordion-item');
        if (!item) return;
        const isActive = item.classList.contains('active');

        document.querySelectorAll('.accordion-item').forEach(accordionItem => {
            accordionItem.classList.remove('active');
        });

        if (!isActive) {
            item.classList.add('active');
        }
    }

    window.toggleAccordion = toggleAccordion;

    // ============ BACK TO TOP BUTTON ============
    const backToTopBtn = document.getElementById('backToTopBtn');
    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

}); // End of DOMContentLoaded
