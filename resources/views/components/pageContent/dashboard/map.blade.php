<!-- Map Area -->
<main class="flex-1 relative bg-gray-200">
    <!-- Leaflet Map Container -->
    <div id="map" class="w-full h-full"></div>
</main>

<!-- Tambahkan di bagian <head> -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Tambahkan script ini sebelum closing </body> atau setelah script yang sudah ada -->
<script>
    // Initialize map centered on Jakarta
    const map = L.map('map').setView([-6.2088, 106.8456], 12);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Custom truck icon
    const truckIcon = L.divIcon({
        html: `<div style="background-color: #ff6b6b; border: 3px solid white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
            <path d="M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z"/>
        </svg>
    </div>`,
        className: 'truck-marker',
        iconSize: [40, 40],
        iconAnchor: [20, 20]
    });

    // Truck data with routes
    const trucks = [{
            id: 'B 7832 POM',
            name: 'B 7832 POM',
            driver: 'Olivia Rodrigo',
            cargo: 'Carrying Chemical',
            color: '#ff6b6b',
            route: [
                [-6.1751, 106.8650], // Starting point
                [-6.1850, 106.8750],
                [-6.1950, 106.8850],
                [-6.2050, 106.8950],
                [-6.2150, 106.9050] // End point
            ],
            currentIndex: 0
        },
        {
            id: 'B 8131 NSA',
            name: 'B 8131 NSA',
            driver: 'John Doe',
            cargo: 'Carrying Chemical',
            color: '#4ecdc4',
            route: [
                [-6.2200, 106.8200],
                [-6.2250, 106.8300],
                [-6.2300, 106.8400],
                [-6.2350, 106.8500],
                [-6.2400, 106.8600]
            ],
            currentIndex: 0
        },
        {
            id: 'F 9832 JNK',
            name: 'F 9832 JNK',
            driver: 'Jane Smith',
            cargo: 'Carrying Chemical',
            color: '#95e1d3',
            route: [
                [-6.2500, 106.8800],
                [-6.2450, 106.8700],
                [-6.2400, 106.8600],
                [-6.2350, 106.8500],
                [-6.2300, 106.8400]
            ],
            currentIndex: 0
        },
        {
            id: 'B 1111 XX',
            name: 'B 1111 XX',
            driver: 'Vladimir Yuri',
            cargo: 'Documents',
            color: '#e90000ff',
            route: [
                [-6.2100, 106.8800],
                [-6.2050, 106.8700],
                [-6.2400, 106.8900],
                [-6.2350, 106.8500],
                [-6.2300, 106.8400]
            ],
            currentIndex: 0
        }
    ];

    // Store markers and polylines
    const truckMarkers = {};
    const routeLines = {};

    // Create markers and routes for each truck
    trucks.forEach(truck => {
        // Create custom colored icon for each truck
        const coloredTruckIcon = L.divIcon({
            html: `<div style="background-color: ${truck.color}; border: 3px solid white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                <path d="M18 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z"/>
            </svg>
        </div>`,
            className: 'truck-marker',
            iconSize: [40, 40],
            iconAnchor: [20, 20]
        });

        // Create marker
        const marker = L.marker(truck.route[0], {
                icon: coloredTruckIcon
            })
            .addTo(map)
            .bindPopup(`
            <div style="min-width: 200px;">
                <h3 style="font-weight: bold; margin-bottom: 8px; color: ${truck.color};">${truck.name}</h3>
                <p style="margin: 4px 0; font-size: 13px;"><strong>Driver:</strong> ${truck.driver}</p>
                <p style="margin: 4px 0; font-size: 13px;"><strong>Status:</strong> ${truck.cargo}</p>
                <p style="margin: 4px 0; font-size: 13px;"><strong>Speed:</strong> 45 km/h</p>
                <button onclick="showFleetDetail('${truck.name}', '${truck.cargo}', '${truck.driver}')" 
                    style="margin-top: 8px; background-color: ${truck.color}; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 12px;">
                    View Details
                </button>
            </div>
        `);

        truckMarkers[truck.id] = marker;

        // Draw route line
        const polyline = L.polyline(truck.route, {
            color: truck.color,
            weight: 4,
            opacity: 0.6,
            dashArray: '10, 10'
        }).addTo(map);

        routeLines[truck.id] = polyline;

        // Add start and end markers
        L.circleMarker(truck.route[0], {
            radius: 6,
            fillColor: truck.color,
            color: 'white',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.8
        }).addTo(map).bindPopup(`<b>Start: ${truck.name}</b>`);

        L.circleMarker(truck.route[truck.route.length - 1], {
            radius: 6,
            fillColor: truck.color,
            color: 'white',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.8
        }).addTo(map).bindPopup(`<b>End: ${truck.name}</b>`);
    });

    // Animate truck movement
    function animateTrucks() {
        trucks.forEach(truck => {
            if (truck.currentIndex < truck.route.length - 1) {
                truck.currentIndex++;
                const newPos = truck.route[truck.currentIndex];
                truckMarkers[truck.id].setLatLng(newPos);

                // Update traveled path (solid line)
                const traveledPath = truck.route.slice(0, truck.currentIndex + 1);
                const traveledPolyline = L.polyline(traveledPath, {
                    color: truck.color,
                    weight: 4,
                    opacity: 1
                });

                // Remove old traveled line if exists
                if (truck.traveledLine) {
                    map.removeLayer(truck.traveledLine);
                }
                truck.traveledLine = traveledPolyline.addTo(map);
            } else {
                // Reset to start
                truck.currentIndex = 0;
                if (truck.traveledLine) {
                    map.removeLayer(truck.traveledLine);
                }
            }
        });
    }

    // Start animation
    setInterval(animateTrucks, 2000); // Move every 2 seconds

    // Add map controls
    L.control.scale().addTo(map);

    // Add legend
    const legend = L.control({
        position: 'bottomright'
    });
    legend.onAdd = function(map) {
        const div = L.DomUtil.create('div', 'info legend');
        div.style.backgroundColor = 'white';
        div.style.padding = '10px';
        div.style.borderRadius = '5px';
        div.style.boxShadow = '0 2px 6px rgba(0,0,0,0.3)';

        div.innerHTML = '<h4 style="margin: 0 0 8px 0; font-weight: bold;">Active Trucks</h4>';

        trucks.forEach(truck => {
            div.innerHTML += `
            <div style="margin: 5px 0; display: flex; align-items: center;">
                <div style="width: 20px; height: 20px; background-color: ${truck.color}; border-radius: 50%; margin-right: 8px; border: 2px solid white; box-shadow: 0 1px 3px rgba(0,0,0,0.3);"></div>
                <span style="font-size: 12px;">${truck.name}</span>
            </div>
        `;
        });

        return div;
    };
    legend.addTo(map);

    // Fit map to show all trucks
    const allPoints = trucks.flatMap(truck => truck.route);
    const bounds = L.latLngBounds(allPoints);
    map.fitBounds(bounds, {
        padding: [50, 50]
    });
</script>

<style>
    /* Custom marker animation */
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(255, 107, 107, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(255, 107, 107, 0);
        }
    }

    .truck-marker {
        animation: pulse 2s infinite;
    }

    /* Ensure map takes full height */
    #map {
        z-index: 1;
    }

    .leaflet-popup-content {
        margin: 8px;
    }

    .leaflet-popup-content-wrapper {
        border-radius: 8px;
    }
</style>