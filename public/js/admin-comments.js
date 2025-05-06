/**
 * FilmWave Admin Comments - JavaScript for dynamic search and filtering
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const searchInput = document.getElementById('searchInput');
    const filterSelect = document.getElementById('filterSelect');
    const commentsContainer = document.getElementById('comments-container');
    
    // Store original comments for filtering
    let allComments = [];
    
    // Initialize: capture all comments
    function initializeComments() {
        const commentElements = commentsContainer.querySelectorAll('.p-4');
        commentElements.forEach(comment => {
            allComments.push({
                element: comment,
                text: comment.textContent.toLowerCase(),
                userData: {
                    name: comment.querySelector('h4').textContent.toLowerCase(),
                    userId: comment.querySelector('.ban-user-btn').getAttribute('data-user-id')
                },
                commentData: {
                    id: comment.querySelector('.delete-comment-btn').getAttribute('data-comment-id'),
                    content: comment.querySelector('p.mt-2.text-gray-700').textContent.toLowerCase(),
                    contentTitle: comment.querySelector('.mt-2.text-xs.text-gray-500 span').textContent.toLowerCase()
                },
                isFlagged: false // You could set this based on some class or data attribute if implemented
            });
        });
    }
    
    // Filter comments based on search text and filter option
    function filterComments() {
        const searchText = searchInput.value.toLowerCase();
        const filterOption = filterSelect.value;
        
        // Hide all comments first
        allComments.forEach(comment => {
            comment.element.style.display = 'none';
        });
        
        // Filter and show matching comments
        allComments.forEach(comment => {
            let shouldShow = false;
            
            // Apply search text filter
            if (searchText === '') {
                shouldShow = true;
            } else {
                if (
                    comment.userData.name.includes(searchText) || 
                    comment.commentData.content.includes(searchText) ||
                    comment.commentData.contentTitle.includes(searchText) ||
                    comment.userData.userId.includes(searchText)
                ) {
                    shouldShow = true;
                }
            }
            
            // Apply category filter if search text passes
            if (shouldShow) {
                if (filterOption === 'all') {
                    // Keep shouldShow value
                } else if (filterOption === 'flagged' && comment.isFlagged) {
                    // Keep shouldShow as true
                } else if (filterOption === 'flagged' && !comment.isFlagged) {
                    shouldShow = false;
                } else if (filterOption === 'recent') {
                    // Here we could filter based on date, but for simplicity we'll keep all
                    // In a real implementation, you might want to check the timestamp
                }
            }
            
            // Show or hide based on filters
            comment.element.style.display = shouldShow ? 'block' : 'none';
        });
        
        // Update UI to show how many results were found
        updateResultsCount();
    }
    
    // Update the results count in the UI
    function updateResultsCount() {
        const visibleComments = allComments.filter(comment => 
            comment.element.style.display !== 'none'
        ).length;
        
        // Update the "Showing x to y of z results" text
        const resultsText = document.querySelector('.text-sm.text-gray-500.mb-4');
        if (resultsText) {
            const pageSize = 10; // This should match your pagination size
            resultsText.innerHTML = `Showing <span class="font-medium">1</span> to <span class="font-medium">${Math.min(visibleComments, pageSize)}</span> of <span class="font-medium">${visibleComments}</span> results`;
        }
    }
    
    // Set up event listeners
    if (searchInput) {
        searchInput.addEventListener('input', debounce(filterComments, 300));
    }
    
    if (filterSelect) {
        filterSelect.addEventListener('change', filterComments);
    }
    
    // Initialize the comment filtering system
    initializeComments();
    
    // Helper function to debounce input events
    function debounce(func, delay) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), delay);
        };
    }
    
    // Live API search functionality
    // This would be used for more advanced implementations
    function searchCommentsAPI(query, filter) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('/admin/api/comments/search', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                query: query,
                filter: filter
            })
        })
        .then(response => response.json())
        .then(data => {
            // This would replace the current comments with the search results
            // For now we'll just use the client-side filtering
            console.log("API search results:", data);
        })
        .catch(error => {
            console.error('Error searching comments:', error);
        });
    }
});