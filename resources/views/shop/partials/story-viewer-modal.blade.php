<!-- Story Viewer Modal (Instagram-style Fullscreen) -->
<div class="modal fade" id="storyViewerModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-black" style="border: none;">
            <div class="modal-body p-0 d-flex align-items-center justify-content-center position-relative" 
                 x-data="storyViewer()" 
                 x-init="init()">
                
                <!-- Close Button -->
                <button type="button" class="btn-close btn-close-white position-fixed top-0 end-0 m-4" 
                        data-bs-dismiss="modal" aria-label="Close" style="z-index: 1060;"></button>
                
                <!-- Progress Bars -->
                <div class="position-fixed top-0 start-0 end-0 d-flex gap-1 p-3" style="z-index: 1050;">
                    <template x-for="(story, index) in stories" :key="index">
                        <div class="flex-grow-1 bg-white bg-opacity-25 rounded-pill overflow-hidden" style="height: 3px;">
                            <div class="bg-white h-100 transition-all"
                                 :style="{ 
                                     width: index < currentIndex ? '100%' : (index === currentIndex ? progress + '%' : '0%'),
                                     transition: index === currentIndex ? 'width 0.1s linear' : 'none'
                                 }"></div>
                        </div>
                    </template>
                </div>

                <!-- Story Header -->
                <div class="position-fixed top-0 start-0 end-0 d-flex align-items-center gap-3 p-3 pt-5" 
                     style="z-index: 1045; background: linear-gradient(to bottom, rgba(0,0,0,0.7), transparent);">
                    <div class="avatar-story-ring no-story" style="width: 40px; height: 40px;">
                        @if(isset($storeSettings['store_logo']) && $storeSettings['store_logo'])
                            <img src="{{ $storeSettings['store_logo'] }}" alt="Loja" class="p-1" style="object-fit: contain; background: #000;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 bg-warning text-dark rounded-circle">
                                <i class="bi bi-shop"></i>
                            </div>
                        @endif
                    </div>
                    <div class="text-white">
                        <div class="fw-bold small">{{ config('app.name', 'Loja') }}</div>
                        <div class="text-white-50 small" x-text="currentStory?.time_ago || ''"></div>
                    </div>
                </div>

                <!-- Story Content -->
                <div class="text-center position-relative w-100 h-100 d-flex align-items-center justify-content-center"
                     @click="handleClick($event)">
                    
                    <!-- Loading State -->
                    <div x-show="loading || imageLoading" class="text-white">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                    </div>

                    <!-- Story Image -->
                    <img x-show="!loading && currentStory" 
                         :src="currentStory?.image_path || ''" 
                         :alt="currentStory?.title || 'Story'"
                         class="img-fluid"
                         style="max-height: 100vh; max-width: 100%; object-fit: contain;"
                         :class="{ 'd-none': imageLoading }"
                         @load="onImageLoad()">

                    <!-- Story Text Overlay & CTA -->
                    <div x-show="currentStory?.title || currentStory?.subtitle || currentStory?.link_url" 
                         class="position-absolute bottom-0 start-0 end-0 p-4 pb-5 text-white text-center pb-md-4"
                         style="background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.6) 50%, transparent 100%); padding-bottom: 60px !important;">
                        
                        <h4 x-text="currentStory?.title || ''" class="mb-1 fw-bold"></h4>
                        <p x-text="currentStory?.subtitle || ''" class="mb-3 opacity-75 small"></p>

                        <!-- CTA Button -->
                        <div x-show="currentStory?.link_url" class="mt-3">
                            <button @click.stop="openLink(currentStory.link_url)" 
                                    class="btn btn-light rounded-pill px-4 py-2 fw-bold d-inline-flex align-items-center animate__animated animate__pulse animate__infinite">
                                <span class="me-2">Saiba Mais</span>
                                <i class="bi bi-chevron-up small"></i>
                            </button>
                        </div>
                    </div>

                    <!-- No Stories State -->
                    <div x-show="!loading && stories.length === 0" class="text-white text-center">
                        <i class="bi bi-images fs-1 mb-3 opacity-50"></i>
                        <p class="opacity-75">Nenhum story disponível no momento.</p>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <button x-show="currentIndex > 0" 
                        @click.stop="prev()" 
                        class="btn btn-link text-white position-fixed start-0 top-50 translate-middle-y fs-1 opacity-50"
                        style="z-index: 1055;">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button x-show="currentIndex < stories.length - 1" 
                        @click.stop="next()" 
                        class="btn btn-link text-white position-fixed end-0 top-50 translate-middle-y fs-1 opacity-50"
                        style="z-index: 1055;">
                    <i class="bi bi-chevron-right"></i>
                </button>

            </div>
        </div>
    </div>
</div>

<script>
    function storyViewer() {
        return {
            stories: [],
            currentIndex: 0,
            progress: 0,
            loading: true,
            imageLoading: true, 
            timer: null,
            duration: 5000, 
            
            get currentStory() {
                return this.stories[this.currentIndex] || null;
            },
            
            init() {
                const modal = document.getElementById('storyViewerModal');
                modal.addEventListener('shown.bs.modal', () => this.loadStories());
                modal.addEventListener('hidden.bs.modal', () => {
                    this.stop();
                    this.stories = [];
                    
                    // Force cleanup of backdrops and body state
                    setTimeout(() => {
                        // Only remove backdrops if NO OTHER modal is currently open
                        // This prevents closing the backdrop of a newly opened modal (like #modal- links)
                        if (!document.querySelector('.modal.show')) {
                            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                            document.body.classList.remove('modal-open');
                            document.body.style.paddingRight = '';
                            document.body.style.overflow = '';
                        }

                        // Special handling for Offcanvas if it's still open (e.g. underlying menu)
                        if (document.querySelector('.offcanvas.show')) {
                            document.body.style.overflow = 'hidden'; 
                        }
                        
                        if (typeof cleanupBackdrops === 'function') {
                            cleanupBackdrops();
                        }
                    }, 50); // Reduced timeout for snappier cleanup
                });
            },
            
            async loadStories() {
                this.loading = true;
                this.imageLoading = true;
                this.currentIndex = 0;
                this.progress = 0;
                
                try {
                    const response = await fetch('/api/stories');
                    const data = await response.json();
                    this.stories = data.stories || [];
                    
                    if (this.stories.length > 0) {
                         // Mark as seen immediately when loaded
                        localStorage.setItem('lastViewedStoryTimestamp', new Date().toISOString());
                    }
                } catch (e) {
                    console.error('Error loading stories:', e);
                    this.stories = [];
                }
                
                this.loading = false;
            },
            
            startTimer() {
                this.stop(); 
                this.progress = 0;
                this.timer = setInterval(() => {
                    this.progress += (100 / (this.duration / 100));
                    
                    if (this.progress >= 100) {
                        this.next();
                    }
                }, 100);
            },
            
            stop() {
                if (this.timer) {
                    clearInterval(this.timer);
                    this.timer = null;
                }
            },
            
            next() {
                this.stop();
                if (this.currentIndex < this.stories.length - 1) {
                    this.currentIndex++;
                    this.imageLoading = true; 
                    this.progress = 0;
                } else {
                    bootstrap.Modal.getInstance(document.getElementById('storyViewerModal'))?.hide();
                }
            },
            
            prev() {
                this.stop();
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                    this.imageLoading = true; 
                    this.progress = 0;
                }
            },
            
            handleClick(event) {
                const rect = event.target.getBoundingClientRect();
                const clickX = event.clientX - rect.left;
                const width = rect.width;
                
                if (clickX < width / 3) {
                    this.prev();
                } else {
                    this.next();
                }
            },
            
            openLink(url) {
                this.stop(); 
                
                if (url.startsWith('#modal-')) {
                    const modalKey = url.replace('#modal-', '');
                    const storyModalEl = document.getElementById('storyViewerModal');
                    const storyModal = bootstrap.Modal.getInstance(storyModalEl);
                    const offcanvasEl = document.getElementById('offcanvasUser');
                    const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);

                    // Function to open the final target modal
                    const launchTargetModal = () => {
                        // FORCE CLEANUP STATE before opening new modal
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                        document.body.classList.remove('modal-open');
                        document.body.style.paddingRight = '';
                        document.body.style.overflow = '';

                        setTimeout(() => {
                            if (typeof openModal === 'function') {
                                openModal(modalKey);
                                const infoModal = new bootstrap.Modal(document.getElementById('infoModal'));
                                infoModal.show();
                            } else {
                                console.error('openModal function not found');
                            }
                        }, 50);
                    };

                    if (storyModal) {
                        storyModalEl.addEventListener('hidden.bs.modal', function onStoryHidden() {
                            storyModalEl.removeEventListener('hidden.bs.modal', onStoryHidden); 
                            
                            if (offcanvasInstance && offcanvasEl.classList.contains('show')) {
                                offcanvasEl.addEventListener('hidden.bs.offcanvas', function onOffcanvasHidden() {
                                    offcanvasEl.removeEventListener('hidden.bs.offcanvas', onOffcanvasHidden);
                                    launchTargetModal();
                                });
                                offcanvasInstance.hide();
                            } else {
                                launchTargetModal();
                            }
                        });
                        storyModal.hide();
                    } else {
                        launchTargetModal();
                    }
                } else {
                    window.open(url, '_blank');
                }
            },
            
            onImageLoad() {
                this.imageLoading = false;
                this.startTimer();
            }
        };
    }
</script>
