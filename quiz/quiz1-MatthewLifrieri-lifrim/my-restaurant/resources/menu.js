fetch('data/menu_items.json')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        data.foods.forEach((item, i) => {
            const index = i + 1;
            document.getElementById(`img-${index}`).src = item.image_url;
            document.getElementById(`img-${index}`).alt = item.name;
            document.getElementById(`name-${index}`).textContent = item.name;
            document.getElementById(`desc-${index}`).textContent = item.description;
            document.getElementById(`category-${index}`).textContent = item.category;
            document.getElementById(`cuisine-${index}`).textContent = item.cuisine;
            document.getElementById(`ingredients-${index}`).textContent = item.ingredients.join(', ');
            document.getElementById(`price-${index}`).textContent = `$${item.price.toFixed(2)}`;
        });
    })
    .catch(error => {
        console.error('Error loading menu data:', error);
    });
