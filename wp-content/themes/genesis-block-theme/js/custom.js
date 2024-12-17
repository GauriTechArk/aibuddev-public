document.getElementById('ai-search-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const query = document.getElementById('ai-query').value;

    fetch(`/wp-json/ai-search/v1/query/?query=${encodeURIComponent(query)}`)
        .then(response => response.text())
        .then(text => {
            if (text.trim() === '') {
                throw new Error('Empty response from server');
            }
            return JSON.parse(text);
        })
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                let resultHtml = '<ul>';
                data.forEach(task => {
                    // Check if task.categories is defined and is an array
                    let categories = 'No categories';
                    if (Array.isArray(task.categories)) {
                        categories = task.categories.map(cat => cat).join(', ');
                    } else if (typeof task.categories === 'string') {
                        categories = task.categories; // Handle case where categories is a string
                    }
                    
                    resultHtml += `
                        <li>
                            <strong>${task.title}</strong><br>
                            ${task.content}<br>
                            <em>Priority: ${task.priority}</em><br>
                            <em>Category: ${categories}</em>
                        </li>`;
                });
                resultHtml += '</ul>';
                document.getElementById('ai-search-results').innerHTML = resultHtml;
            } else {
                document.getElementById('ai-search-results').innerHTML = 'No tasks found.';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('ai-search-results').innerHTML = 'Error processing your request.';
        });
});