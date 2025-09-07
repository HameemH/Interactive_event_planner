<?php
use App\Models\Event;
?>
@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-[calc(100vh-64px)] relative">
        <!-- Card Container with Estimated Cost Counter -->
        <div class="glass-card p-10 pt-8 rounded-3xl w-[600px] min-h-[500px] flex flex-col justify-between shadow-lg">
            <!-- Estimated Cost Counter in Top Right -->
            <div class="absolute top-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-full text-sm">
                <span id="estimated-cost">Estimated Cost: $0</span>
            </div>
            <!-- Total Estimated Price Section -->
            <div class="absolute top-16 right-4 bg-indigo-800 text-white px-4 py-2 rounded-full text-sm">
                <span id="total-estimated-cost">Total Estimated Price: $0</span>
            </div>

            <!-- Go Back Button (Top Left) -->
            <a href="{{ route('custom-event.seating') }}" class="absolute top-4 left-4 text-gray-700 hover:text-indigo-600 font-semibold">
                &#8592; Go Back
            </a>

            <!-- Title of the Card -->
            <h1 class="text-2xl font-extrabold text-gray-800 mb-4">Select Stage & Decoration</h1>

            <form method="POST" action="{{ route('custom-event.catering') }}">
                @csrf

                <!-- Stage Selection -->
                <div class="mb-4">
                    <label for="stage_type" class="block text-left mb-2">Choose Stage Type</label>
                    <select name="stage_type" id="stage_type" class="w-full bg-transparent outline-none text-base">
                        <option value="basic">Basic</option>
                        <option value="premium">Premium</option>
                        <option value="luxury">Luxury</option>
                    </select>
                </div>
                <!-- Stage Images Selector (inline, updates with stage type) -->
                <div id="stage-images-selector" class="mb-4 grid grid-cols-2 md:grid-cols-3 gap-4"></div>

                <!-- Stage Image Selection (Popup Slider) -->
                <div id="stage-image-section" class="mb-4">
                    <label for="stage_image" class="block text-left mb-2">Choose Stage Image</label>
                    <input type="text" name="stage_image" id="stage_image" readonly class="w-full bg-transparent outline-none text-base" placeholder="Select a stage image">
                    <button type="button" id="open-slider" class="w-full py-2 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform">
                        Open Image Slider
                    </button>
                </div>

                <!-- Surrounding Decoration Option -->
                <div class="mb-4">
                    <label for="surrounding_decoration" class="block text-left mb-2">Add Surrounding Decoration</label>
                    <input type="checkbox" name="surrounding_decoration" id="surrounding_decoration" class="form-checkbox">
                    <button type="button" id="open-decoration-slider" class="w-full py-2 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform mt-2">
                        Choose Decoration Image
                    </button>
                    <input type="hidden" name="decoration_image" id="decoration_image">
                    <div id="selected-decoration-image" class="mt-2"></div>
                </div>

                <button type="submit" class="w-full py-3 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform mt-auto">
                    Next: Select Catering
                </button>
            </form>
        </div>
    </div>

    <!-- Stage Image Slider Popup -->
    <div id="stage-image-slider" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg w-[80%] md:w-[60%]">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Select a Stage Image</h3>
            <div id="stage-images" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Images will be dynamically inserted here -->
            </div>
            <button id="close-slider" class="mt-4 py-2 px-4 bg-indigo-600 text-white rounded-lg">Close</button>
        </div>
    </div>

    <!-- Decoration Image Slider Popup -->
    <div id="decoration-image-slider" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg w-[80%] md:w-[60%]">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Select a Decoration Image</h3>
            <div id="decoration-images" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Images will be dynamically inserted here -->
            </div>
            <button id="close-decoration-slider" class="mt-4 py-2 px-4 bg-indigo-600 text-white rounded-lg">Close</button>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Helper: Get images for selected stage type
                function getStageImagesArray(selectedStage) {
                    if (selectedStage === 'basic') {
                        return [
                            'https://drive.google.com/uc?export=view&id=1Dw8ax14cOG_qfgPI_ei8BjFLnEorSngr',
                            'https://drive.google.com/uc?export=view&id=1ZBWxiWGvpPseLtDcwajNoQD0MB02qoe8',
                            'https://drive.google.com/uc?export=view&id=1GVRn3fVxehx8-5AeygDG6FwpJfyReN0p'
                        ];
                    } else if (selectedStage === 'premium') {
                        return [
                            'https://drive.google.com/uc?export=view&id=1qgN2OC1aEd97kmx_WUBBFUzlns3Hyfhp',
                            'https://drive.google.com/uc?export=view&id=1eJgxA_iRgzp3bw_3caXsHFzeth0srKJO',
                            'https://drive.google.com/uc?export=view&id=171L1Y4g94X5yy4ZA2RGv-K83yPObXycI'
                        ];
                    } else if (selectedStage === 'luxury') {
                        return [
                            'https://drive.google.com/uc?export=view&id=1tJmZbvy1nqMZhO-mDJvdAAQ6iKpw4rzI',
                            'https://drive.google.com/uc?export=view&id=1jqJYObxfuvaa0SDPwlQ7RxSPBS2zG075',
                            'https://drive.google.com/uc?export=view&id=1LDOdhbpWtGrQsHrHDf_PPWS2rFFNcFVv'
                        ];
                    }
                    return [];
                }

                // Render images in the slider popup
                function renderStageImagesSlider() {
                    var selectedStage = stageTypeSelect.value;
                    var sliderImages = getStageImagesArray(selectedStage);
                    stageImages.innerHTML = '';
                    for (var i = 0; i < sliderImages.length; i++) {
                        var image = sliderImages[i];
                        var imgElement = document.createElement('img');
                        imgElement.src = image;
                        imgElement.alt = 'Stage image';
                        imgElement.classList.add('cursor-pointer', 'rounded-lg', 'border', 'border-gray-300', 'hover:border-indigo-600');
                        imgElement.setAttribute('data-image', image);
                        imgElement.style.height = '120px';
                        imgElement.style.objectFit = 'cover';
                        imgElement.onerror = function() {
                            this.alt = 'Image could not be loaded';
                        };
                        // Highlight if selected
                        if (stageImageInput.value === image) {
                            imgElement.classList.add('ring', 'ring-indigo-500');
                        }
                        imgElement.addEventListener('click', function() {
                            stageImageInput.value = this.getAttribute('data-image');
                            updateStageCost();
                            stageImageSlider.classList.add('hidden');
                            stageImages.innerHTML = '';
                        });
                        stageImages.appendChild(imgElement);
                    }
                }
                const stageTypeSelect = document.getElementById('stage_type');
                const stageImageInput = document.getElementById('stage_image');
                const openSliderButton = document.getElementById('open-slider');
                const stageImageSlider = document.getElementById('stage-image-slider');
                const closeSliderButton = document.getElementById('close-slider');
                const stageImages = document.getElementById('stage-images');
                const stageImagesSelector = document.getElementById('stage-images-selector');
                const surroundingDecorationCheckbox = document.getElementById('surrounding_decoration');
                const estimatedCostElement = document.getElementById('estimated-cost');
                const totalEstimatedCostElement = document.getElementById('total-estimated-cost');

                // Helper: Save stage info to localStorage
                function saveStageInfo(type, image, decoration, cost) {
                    const stageData = {
                        type: type,
                        image: image,
                        decoration: decoration,
                        decoration_image: document.getElementById('decoration_image').value || '',
                        cost: cost
                    };
                    localStorage.setItem('event_stage', JSON.stringify(stageData));
                    updateTotalEstimatedCost();
                }

                // Helper: Update total estimated cost from all steps
                function updateTotalEstimatedCost() {
                    let total = 0;
                    // Venue
                    const venue = JSON.parse(localStorage.getItem('event_venue') || '{}');
                    if (venue.cost) total += venue.cost;
                    // Seating
                    const seating = JSON.parse(localStorage.getItem('event_seating') || '{}');
                    if (seating.cost) total += seating.cost;
                    // Stage
                    const stage = JSON.parse(localStorage.getItem('event_stage') || '{}');
                    if (stage.cost) total += stage.cost;
                    // Catering
                    const catering = JSON.parse(localStorage.getItem('event_catering') || '{}');
                    if (catering.cost) total += catering.cost;
                    // Photography
                    const photography = JSON.parse(localStorage.getItem('event_photography') || '{}');
                    if (photography.cost) total += photography.cost;
                    // Extra Options
                    const extra = JSON.parse(localStorage.getItem('event_extra') || '{}');
                    if (extra.cost) total += extra.cost;
                    totalEstimatedCostElement.innerText = `Total Estimated Price: $${total}`;
                }

                // Helper: Get venue size from localStorage
                function getVenueSize() {
                    const venue = JSON.parse(localStorage.getItem('event_venue') || '{}');
                    return venue.size || 0;
                }

                // Function to open the image slider
                openSliderButton.addEventListener('click', function() {
                    console.log('Slider button clicked');
                    stageImageSlider.classList.remove('hidden');
                    renderStageImagesSlider();
                });

                // Decoration slider logic
                var decorationImagesArr = [
                    'https://drive.google.com/uc?export=view&id=1cZxk1-kxjS8I9gFuglQIrDo6F0bpecSa',
                    'https://drive.google.com/uc?export=view&id=1dYP3QtlF2h_HgydaLGL5NNc2JKwwRATg',
                    'https://drive.google.com/uc?export=view&id=1oz8aFOHtgeFCxHp5nvVZpVHhKAC-vf_z'
                ];
                var openDecorationSliderButton = document.getElementById('open-decoration-slider');
                var decorationImageSlider = document.getElementById('decoration-image-slider');
                var closeDecorationSliderButton = document.getElementById('close-decoration-slider');
                var decorationImages = document.getElementById('decoration-images');
                var decorationImageInput = document.getElementById('decoration_image');

                openDecorationSliderButton.addEventListener('click', function() {
                    decorationImageSlider.classList.remove('hidden');
                    decorationImages.innerHTML = '';
                    for (var i = 0; i < decorationImagesArr.length; i++) {
                        var image = decorationImagesArr[i];
                        var imgElement = document.createElement('img');
                        imgElement.src = image;
                        imgElement.alt = 'Decoration image';
                        imgElement.classList.add('cursor-pointer', 'rounded-lg', 'border', 'border-gray-300', 'hover:border-indigo-600');
                        imgElement.setAttribute('data-image', image);
                        imgElement.style.height = '120px';
                        imgElement.style.objectFit = 'cover';
                        imgElement.onerror = function() {
                            this.alt = 'Image could not be loaded';
                        };
                        if (decorationImageInput.value === image) {
                            imgElement.classList.add('ring', 'ring-indigo-500');
                        }
                        imgElement.addEventListener('click', function() {
                            decorationImageInput.value = this.getAttribute('data-image');
                            decorationImageSlider.classList.add('hidden');
                            decorationImages.innerHTML = '';
                            // Show selected image in form
                            var selectedDiv = document.getElementById('selected-decoration-image');
                            selectedDiv.innerHTML = '<img src="' + this.getAttribute('data-image') + '" alt="Selected Decoration" class="rounded-lg border border-indigo-500 mt-2" style="height:120px;object-fit:cover;">';
                            // Save to localStorage immediately, but do NOT update price
                            // Get current cost from localStorage
                            var stageData = JSON.parse(localStorage.getItem('event_stage') || '{}');
                            var currentCost = stageData.cost || estimatedCostElement.innerText.replace(/[^\d]/g, '');
                            saveStageInfo(stageTypeSelect.value, stageImageInput.value, surroundingDecorationCheckbox.checked, currentCost);
                        });
                        decorationImages.appendChild(imgElement);
                    }
                });
                closeDecorationSliderButton.addEventListener('click', function() {
                    decorationImageSlider.classList.add('hidden');
                    decorationImages.innerHTML = '';
                });

                // Dynamically load images based on the selected stage type
                function loadImagesBasedOnStageType() {
                    const selectedStage = stageTypeSelect.value;
                    let images = [];
                    // Basic stage images
                    if (selectedStage === 'basic') {
                        images = [
                            'https://drive.google.com/uc?export=view&id=1Dw8ax14cOG_qfgPI_ei8BjFLnEorSngr',
                            'https://drive.google.com/uc?export=view&id=1ZBWxiWGvpPseLtDcwajNoQD0MB02qoe8',
                            'https://drive.google.com/uc?export=view&id=1GVRn3fVxehx8-5AeygDG6FwpJfyReN0p'
                        ];
                    }
                    // Premium stage images
                    else if (selectedStage === 'premium') {
                        images = [
                            'https://drive.google.com/uc?export=view&id=1qgN2OC1aEd97kmx_WUBBFUzlns3Hyfhp',
                            'https://drive.google.com/uc?export=view&id=1eJgxA_iRgzp3bw_3caXsHFzeth0srKJO',
                            'https://drive.google.com/uc?export=view&id=171L1Y4g94X5yy4ZA2RGv-K83yPObXycI'
                        ];
                    }
                    // Luxury stage images
                    else if (selectedStage === 'luxury') {
                        images = [
                            'https://drive.google.com/uc?export=view&id=1tJmZbvy1nqMZhO-mDJvdAAQ6iKpw4rzI',
                            'https://drive.google.com/uc?export=view&id=1jqJYObxfuvaa0SDPwlQ7RxSPBS2zG075',
                            'https://drive.google.com/uc?export=view&id=1LDOdhbpWtGrQsHrHDf_PPWS2rFFNcFVv'
                        ];
                    }
                    // Inline selector rendering (always runs)
                    var selectorImages = getStageImagesArray(stageTypeSelect.value);
                    stageImagesSelector.innerHTML = '';
                    for (var i = 0; i < selectorImages.length; i++) {
                        var image = selectorImages[i];
                        var imgElement = document.createElement('img');
                        imgElement.src = image;
                        imgElement.alt = 'Stage image';
                        imgElement.classList.add('cursor-pointer', 'rounded-lg', 'border', 'border-gray-300', 'hover:border-indigo-600');
                        imgElement.setAttribute('data-image', image);
                        imgElement.style.height = '120px';
                        imgElement.style.objectFit = 'cover';
                        imgElement.onerror = function() {
                            this.alt = 'Image could not be loaded';
                        };
                        // Highlight if selected
                        if (stageImageInput.value === image) {
                            imgElement.classList.add('ring', 'ring-indigo-500');
                        }
                        imgElement.addEventListener('click', function() {
                            stageImageInput.value = this.getAttribute('data-image');
                            updateStageCost();
                            // Rerender to highlight selected
                            loadImagesBasedOnStageType();
                        });
                        stageImagesSelector.appendChild(imgElement);
                    }

                    // Popup slider rendering (always runs)
                    stageImages.innerHTML = '';
                    images.forEach(image => {
                        const imgElement = document.createElement('img');
                        imgElement.src = image;
                        imgElement.alt = 'Stage image';
                        imgElement.classList.add('cursor-pointer', 'rounded-lg', 'border', 'border-gray-300', 'hover:border-indigo-600');
                        imgElement.setAttribute('data-image', image);
                        imgElement.style.height = '120px';
                        imgElement.style.objectFit = 'cover';
                        imgElement.onerror = function() {
                            imgElement.alt = 'Image could not be loaded';
                        };
                        // Highlight if selected
                        if (stageImageInput.value === image) {
                            imgElement.classList.add('ring', 'ring-indigo-500');
                        }
                        imgElement.addEventListener('click', function() {
                            stageImageInput.value = image;
                            updateStageCost();
                            stageImageSlider.classList.add('hidden');
                            // Rerender to highlight selected
                            loadImagesBasedOnStageType();
                        });
                        stageImages.appendChild(imgElement);
                    });
                }

                // Calculate and update cost
                function updateStageCost() {
                    const venueSize = getVenueSize();
                    let decorationCost = 0;
                    if (surroundingDecorationCheckbox.checked) {
                        decorationCost = venueSize * 10;
                    }
                    const stageCost = stageTypeSelect.value === 'premium' ? 50 : (stageTypeSelect.value === 'luxury' ? 100 : 20);
                    const totalCost = stageCost + decorationCost;
                    estimatedCostElement.innerText = `Estimated Cost: $${totalCost}`;
                    saveStageInfo(stageTypeSelect.value, stageImageInput.value, surroundingDecorationCheckbox.checked, totalCost);
                }

                // When an image is selected from the slider
                stageImages.addEventListener('click', function(e) {
                    if (e.target.tagName === 'IMG') {
                        const selectedImage = e.target.getAttribute('data-image');
                        stageImageInput.value = selectedImage;
                        stageImageSlider.classList.add('hidden');
                        updateStageCost();
                    }
                });

                // Update cost when surrounding decoration is toggled
                surroundingDecorationCheckbox.addEventListener('change', updateStageCost);
                // Also update when stage type changes
                stageTypeSelect.addEventListener('change', updateStageCost);

                // On page load, restore stage info and total price
                (function restoreStageInfo() {
                    const stage = JSON.parse(localStorage.getItem('event_stage') || '{}');
                    if (stage.type) stageTypeSelect.value = stage.type;
                    if (stage.image) stageImageInput.value = stage.image;
                    if (stage.decoration) surroundingDecorationCheckbox.checked = stage.decoration;
                    if (stage.decoration_image) {
                        decorationImageInput.value = stage.decoration_image;
                        var selectedDiv = document.getElementById('selected-decoration-image');
                        selectedDiv.innerHTML = '<img src="' + stage.decoration_image + '" alt="Selected Decoration" class="rounded-lg border border-indigo-500 mt-2" style="height:120px;object-fit:cover;">';
                    }
                    if (stage.cost) estimatedCostElement.innerText = `Estimated Cost: $${stage.cost}`;
                    updateTotalEstimatedCost();
                })();
            });
        </script>
    @endsection
@endsection
