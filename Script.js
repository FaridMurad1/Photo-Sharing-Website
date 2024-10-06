// Sidebar functionality
function showSidebar(){
    const sidebar = document.querySelector('.sidebar');
    sidebar.style.display = 'flex';
}

function closeSidebar(){
    const sidebar = document.querySelector('.sidebar');
    sidebar.style.display = 'none';
}

// Close sidebar when clicking outside of the sidebar content
document.addEventListener('click', function(event) {
    var sidebar = document.getElementById('sidebarContainer');
    if (!sidebar.contains(event.target) && !event.target.closest('.menu-button')) {
        closeSidebar();
    }
});

document.addEventListener('click', function(event) {
    var sidebar = document.getElementById('sidebarContainerProfile');
    if (!sidebar.contains(event.target) && !event.target.closest('.profile-menu')) {
        closeSidebar();
    }
});

// Modal-related functionality (login, register, upload modals)
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modal');
    const modalContent = document.getElementById('modal-content');

    // Links for opening login/register/upload forms
    const loginLink = document.getElementById('loginLink');
    const registerLink = document.getElementById('registerLink');
    const loginLinkSidebar = document.getElementById('loginLinkSidebar');
    const registerLinkSidebar = document.getElementById('registerLinkSidebar');
    const uploadLink = document.getElementById('uploadLink');
    const uploadLinkSidebar = document.getElementById('uploadLinkSidebar');

    // Event listeners for opening modals
    loginLink?.addEventListener('click', openLoginModal);
    loginLinkSidebar?.addEventListener('click', openLoginModal);
    registerLink?.addEventListener('click', openRegisterModal);
    registerLinkSidebar?.addEventListener('click', openRegisterModal);
    uploadLink?.addEventListener('click', openUploadModal);
    uploadLinkSidebar?.addEventListener('click', openUploadModal);

    // Close modal when clicking outside the content
    window.addEventListener('click', function(e) {
        if (e.target == modal) {
            modal.style.display = 'none'; // Hide modal
        }
    });

    // Load login form and open modal
    function openLoginModal(event) {
        event.preventDefault(); // Prevent default navigation
        fetch('Login.php') // Load login.html dynamically
            .then(response => response.text())
            .then(html => {
                modalContent.innerHTML = html; // Inject login form
                modal.style.display = 'flex'; // Display modal
                attachShowPasswordListener(); // Attach show password toggle
                setupRegisterSwitch(); // Setup switch to register
            });
    }

    // Load register form and open modal
    function openRegisterModal(event) {
        event.preventDefault(); // Prevent default navigation
        fetch('Register.php') // Load register.html dynamically
            .then(response => response.text())
            .then(html => {
                modalContent.innerHTML = html; // Inject register form
                modal.style.display = 'flex'; // Display modal
                attachShowPasswordListener(); // Attach show password toggle
                setupLoginSwitch(); // Setup switch to login
            });
    }

    // Load upload form and open modal
    function openUploadModal(event) {
        event.preventDefault(); // Prevent default navigation
        fetch('Upload.php') // Load upload.html dynamically
            .then(response => response.text())
            .then(html => {
                modalContent.innerHTML = html; // Inject upload form
                modal.style.display = 'flex'; // Display modal
            });
    }

    // Toggle password visibility
    function attachShowPasswordListener() {
        const showPasswordCheckbox = document.getElementById('show_password');
        const passwordInput = document.querySelector('input[name="password"]');

        if (showPasswordCheckbox && passwordInput) {
            showPasswordCheckbox.addEventListener('change', function() {
                passwordInput.type = this.checked ? 'text' : 'password';
            });
        }
    }

    // Switch from login to register form
    function setupRegisterSwitch() {
        const openRegisterLink = document.getElementById('openRegisterLink');
        if (openRegisterLink) {
            openRegisterLink.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default behavior
                openRegisterModal(event); // Call openRegisterModal function
            });
        }
    }

    // Switch from register to login form
    function setupLoginSwitch() {
        const openLoginLink = document.getElementById('openLoginLink');
        if (openLoginLink) {
            openLoginLink.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default behavior
                openLoginModal(event); // Call openLoginModal function
            });
        }
    }
});

// Image grid functionality

// Global variable to hold all images data
let allImagesData = []; // Initialize this array to hold your images data
let imagesLoaded = 0; // Track how many images have been loaded
const imagesPerBatch = 24; // Number of images to load per batch

document.addEventListener('DOMContentLoaded', function() {
    // Load images into the grid and store them in allImagesData
    function loadImages() {
        const imageGrid = document.getElementById('imageGrid');

        for (let i = imagesLoaded; i < imagesLoaded + imagesPerBatch && i < imageData.length; i++) {
            // Store the image data in the allImagesData array
            allImagesData.push(imageData[i]);

            const imageItem = document.createElement('div');
            imageItem.className = 'image-item';

            const imgElement = document.createElement('img');
            imgElement.src = imageData[i].url;
            imgElement.alt = imageData[i].title;

            imgElement.addEventListener('click', () => {
                const imageUrl = imageData[i].url; // Encode the URL
                openDownloadModal(imageUrl); // Open the download modal with editing
            });

            const titleElement = document.createElement('div');
            titleElement.className = 'image-title';
            titleElement.textContent = imageData[i].title;

            imageItem.appendChild(imgElement);
            imageItem.appendChild(titleElement);

            imageGrid.appendChild(imageItem);
        }

        imagesLoaded += imagesPerBatch;
        console.log(allImagesData.length, imageData.length, imagesLoaded);

        // Hide load more button if all images are loaded
        if (imagesLoaded >= imageData.length) {
            document.getElementById('loadMoreButton').style.display = 'none'; // Hide load more button
        }
    }

    // Load more button functionality
    const loadMoreButton = document.getElementById('loadMoreButton');
    loadMoreButton.addEventListener('click', loadImages); // Add click event to load more images

    // Initial load
    loadImages();
});

// Search function
function search() {
    // Prevent the default form submission
    event.preventDefault();

    // Get the search query from the input field
    const searchQuery = document.querySelector('input[name="Search"]').value.toLowerCase();

    // Clear the current image grid
    const imageGrid = document.getElementById('imageGrid');
    imageGrid.innerHTML = '';

    // Filter images based on title and tags from the entire imageData array
    const filteredImages = imageData.filter(image => 
        image.title.toLowerCase().includes(searchQuery) || 
        image.tags.toLowerCase().includes(searchQuery)
    );

    // Check if any images match the search
    if (filteredImages.length > 0) {
        // Reset imagesLoaded for the search results
        imagesLoaded = 0;

        // Function to load the filtered images in batches
        const loadFilteredImages = (start) => {
            for (let i = start; i < start + imagesPerBatch && i < filteredImages.length; i++) {
                const imageItem = document.createElement('div');
                imageItem.className = 'image-item';

                const imgElement = document.createElement('img');
                imgElement.src = filteredImages[i].url;
                imgElement.alt = filteredImages[i].title;

                imgElement.addEventListener('click', () => {
                    const imageUrl = filteredImages[i].url; // Get the image URL
                    openDownloadModal(imageUrl); // Open the download modal with editing
                });

                const titleElement = document.createElement('div');
                titleElement.className = 'image-title';
                titleElement.textContent = filteredImages[i].title;

                imageItem.appendChild(imgElement);
                imageItem.appendChild(titleElement);

                imageGrid.appendChild(imageItem);
            }

            imagesLoaded += imagesPerBatch;
            console.log(filteredImages.length, imagesLoaded);

            // Hide load more button if all filtered images are loaded
            if (imagesLoaded >= filteredImages.length) {
                document.getElementById('loadMoreButton').style.display = 'none'; // Hide load more button
            } else {
                document.getElementById('loadMoreButton').style.display = 'block'; // Show load more button
            }
        };

        // Load the first batch of filtered images
        loadFilteredImages(imagesLoaded);
    } else {
        // Display a message if no images are found
        const noResults = document.createElement('div');
        noResults.className = 'no-results';
        noResults.textContent = 'No results found for your search.';
        imageGrid.appendChild(noResults);

        // Hide the load more button as there are no results
        document.getElementById('loadMoreButton').style.display = 'none';
    }
}






// Open download modal with image editing functionality
function openDownloadModal(imageUrl) {
    const modal = document.getElementById('downloadModal');
    const modalContent = document.getElementById('modalContent');

    // Prevent the default behavior of the anchor tag
    
    
    // Fetch the content of Download.html
    fetch('Download.php')
        .then(response => response.text())
        .then(html => {
            modalContent.innerHTML = html; // Inject the fetched HTML

            // Set the image URL in the modal's content
            const previewImage = modalContent.querySelector('#downloadImage');
            if (previewImage) {
                previewImage.src = imageUrl; // Set the image source
                console.log(previewImage.src);
                previewImage.alt = "Image Preview"; // Add alt text for accessibility

                // Initialize filters, rotation, flip functionality
                initializeImageEditing(previewImage); // Initialize filters, rotation, flip, download
            }

            // Display the modal
            modal.style.display = 'flex';
            document.body.classList.add('modal-open'); // Add class to body to prevent scrolling            
            
        })
        .catch(error => console.error('Error loading the Download.php:', error));
}

// Close the download modal when clicking the close button
const closeDownloadModal = document.getElementsByClassName('close')[0];
// closeDownloadModal.onclick = function() {
//     const modal = document.getElementById('downloadModal');
//     modal.style.display = 'none'; // Hide the modal
//     document.body.classList.remove('modal-open'); // Remove class to allow scrolling
// }

// Close the modal when clicking outside of the modal content
window.addEventListener('click', function(e) {
    const modal = document.getElementById('downloadModal');
    if (e.target == modal) {
        modal.style.display = 'none'; // Hide the modal
        document.body.classList.remove('modal-open'); // Remove class to allow scrolling
    }
});


// Show images on profile page
document.addEventListener('DOMContentLoaded', function() {
    const imageGrid = document.getElementById('userImageGrid');

    if (userImagesData && userImagesData.length > 0) { // Ensure userImagesData is defined and has data
        userImagesData.forEach(image => {
            const userImageItem = document.createElement('div');
            userImageItem.className = 'user-image-item';

            const userImgElement = document.createElement('img');
            userImgElement.src = image.url;
            userImgElement.alt = image.title;

            const userTitleElement = document.createElement('div');
            userTitleElement.className = 'image-title';
            userTitleElement.textContent = image.title;

            // Append the image and title to the div
            userImageItem.appendChild(userImgElement);
            userImageItem.appendChild(userTitleElement);

            // Add click event to redirect to the image detail page
            userImageItem.onclick = function() {
                window.location.href = `image_detail.php?image_url=${image.url}`; // Pass the image ID or URL
            };

            // Append the div to the image grid
            imageGrid.appendChild(userImageItem);
        });
    } else {
        imageGrid.innerHTML = "<p>No images uploaded yet.</p>";
    }
});




// Function to initialize filters, rotation, flip, and download functionality
function initializeImageEditing(previewImage) {
    let brightness = 100, saturation = 100, inversion = 0, grayscale = 0;
    let rotate = 0, flipHorizontal = 1, flipVertical = 1;
    let activeFilter = 'brightness';

    const filterButtons = document.querySelectorAll('.filter .option button'); // Filter buttons
    const filterSlider = document.querySelector('.slider input'); // Filter slider
    const filterValue = document.querySelector('.slider .value'); // Filter value display
    const filterName = document.querySelector('.slider .name'); // Filter name display
    const rotateButtons = document.querySelectorAll('.rotate .option button'); // Rotate & flip buttons
    const resetButton = document.getElementById('reset'); // Reset button (can be hidden)
    const downloadButton = document.getElementById('download'); // Download button

    // Update image filter styles
    function applyFilters() {
        console.log(`Applying filters: brightness(${brightness}%), saturation(${saturation}%), invert(${inversion}%), grayscale(${grayscale}%)`);
        previewImage.style.filter = `
            brightness(${brightness}%)
            saturate(${saturation}%)
            invert(${inversion}%)
            grayscale(${grayscale}%)
        `;
        previewImage.style.transform = `
            rotate(${rotate}deg)
            scale(${flipHorizontal}, ${flipVertical})
        `;
    }

    // Event listener for filter buttons
    filterButtons.forEach((button) => {
        button.addEventListener('click', function() {
            document.querySelector('.filter .option .active').classList.remove('active');
            this.classList.add('active');
            activeFilter = this.textContent.toLowerCase(); // Get active filter name
            filterName.textContent = activeFilter.charAt(0).toUpperCase() + activeFilter.slice(1); // Capitalize first letter

            if (filterSlider) {
                filterSlider.value = getFilterValue(activeFilter);
                filterValue.textContent = `${filterSlider.value}%`;
            }

            applyFilters(); // Apply the updated filter immediately after selection
        });
    });

    // Get current filter value
    function getFilterValue(filter) {
        switch (filter) {
            case 'brightness': return brightness;
            case 'saturation': return saturation;
            case 'inversion': return inversion;
            case 'grayscale': return grayscale;
        }
    }

    // Event listener for filter slider
    if (filterSlider) {
        filterSlider.addEventListener('input', function() {
            filterValue.textContent = `${this.value}%`; // Update value display
            updateFilterValue(activeFilter, this.value); // Update active filter value
            applyFilters(); // Apply the updated filter
        });
    }

    // Update filter values based on active filter
    function updateFilterValue(filter, value) {
        switch (filter) {
            case 'brightness': brightness = value; break;
            case 'saturation': saturation = value; break;
            case 'inversion': inversion = value; break;
            case 'grayscale': grayscale = value; break;
        }
    }

    // Event listener for rotate & flip buttons
    rotateButtons.forEach((button) => {
        button.addEventListener('click', function() {
            switch (this.textContent) {
                case 'rot-left': rotate -= 90; break;
                case 'rot-right': rotate += 90; break;
                case 'ref-hor': flipHorizontal = flipHorizontal === 1 ? -1 : 1; break;
                case 'ref-ver': flipVertical = flipVertical === 1 ? -1 : 1; break;
            }
            applyFilters(); // Apply rotation and flip transformations
        });
    });

    // Reset function (you can hide the button, but still define this)
    function resetFilters() {
        brightness = 100;
        saturation = 100;
        inversion = 0;
        grayscale = 0;
        rotate = 0;
        flipHorizontal = 1;
        flipVertical = 1;

        if (filterSlider) {
            filterSlider.value = brightness;
            filterValue.textContent = '100%';
            filterName.textContent = 'Brightness';
        }
        document.querySelector('.filter .option .active').classList.remove('active');
        filterButtons[0].classList.add('active');

        applyFilters(); // Apply default filters
    }

    // Event listener for reset button (if it exists)
    if (resetButton) {
        resetButton.addEventListener('click', resetFilters);
    }

    // Event listener for download button
    downloadButton.addEventListener('click', function() {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        // Set canvas dimensions to image dimensions
        canvas.width = previewImage.naturalWidth || previewImage.width;
        canvas.height = previewImage.naturalHeight || previewImage.height;

        // Apply transformations on the canvas
        ctx.filter = `
            brightness(${brightness}%)
            saturate(${saturation}%)
            invert(${inversion}%)
            grayscale(${grayscale}%)
        `;

        // Apply rotation and flip
        ctx.translate(canvas.width / 2, canvas.height / 2);
        ctx.rotate((rotate * Math.PI) / 180);
        ctx.scale(flipHorizontal, flipVertical);
        ctx.drawImage(previewImage, -canvas.width / 2, -canvas.height / 2);

        // Create a download link for the edited image
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/jpeg');
        link.download = 'image.jpg';
        link.click();
    });
}

// Ensure the function is called once the document is ready
document.addEventListener('DOMContentLoaded', function() {
    const previewImage = document.getElementById('downloadImage'); // Ensure this is present
    if (previewImage) {
        initializeImageEditing(previewImage);
    } else {
        console.error('Image element not found.');
    }
});