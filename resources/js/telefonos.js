document.addEventListener('DOMContentLoaded', function() {
    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');
    const filterButton = document.getElementById('filter-button');

    if (stateSelect) {
        stateSelect.addEventListener('change', function () {
            const stateId = this.value;

            if (stateId) {
                fetch(`/api/cities?state_id=${stateId}`)
                    .then(response => response.json())
                    .then(data => {
                        citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
                        data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                    });
            } else {
                citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
                // You'll need to pass the cities data to JavaScript some other way
                // for example, by using a data attribute or a global JavaScript variable
            }
        });
    }

    if (filterButton) {
        filterButton.addEventListener('click', function () {
            const stateId = stateSelect.value;
            const cityId = citySelect.value;
            const url = new URL(window.location.href);
            url.searchParams.set('state_id', stateId);
            url.searchParams.set('city_id', cityId);
            window.location.href = url.toString();
        });
    }
});
