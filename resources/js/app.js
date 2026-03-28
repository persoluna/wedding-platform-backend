import './bootstrap';
import Alpine from 'alpinejs';
import { initParticleBackground } from './particles';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    // Particle Background Data component
    Alpine.data('partyBg', () => ({
        cleanup: null,
        init() {
            // Need slight delay to ensure canvas is properly sized in DOM
            setTimeout(() => {
                this.cleanup = initParticleBackground(this.$refs.canvas);
            }, 50);
        },
        destroy() {
            if (this.cleanup) this.cleanup();
        }
    }));

    // Hero Search Data component
    Alpine.data('heroSearch', (serverLocations = null) => ({
        locationQuery: '',
        showLocationDropdown: false,
        selectedLocation: '',
        apiLocations: [],
        isSearching: false,
        indianLocations: serverLocations || [
            "Mumbai, Maharashtra", "Delhi, NCR", "Bangalore, Karnataka", "Chennai, Tamil Nadu", 
            "Kolkata, West Bengal", "Hyderabad, Telangana", "Pune, Maharashtra", "Ahmedabad, Gujarat",
            "Gurgaon, Haryana", "Noida, Uttar Pradesh", "Surat, Gujarat", "Vadodara, Gujarat",
            "Jaipur, Rajasthan", "Udaipur, Rajasthan", "Jodhpur, Rajasthan", "Jaisalmer, Rajasthan",
            "Goa", "Kochi, Kerala", "Alleppey, Kerala", "Munnar, Kerala", "Kumarakom, Kerala",
            "Rishikesh, Uttarakhand", "Mussoorie, Uttarakhand", "Shimla, Himachal Pradesh", "Manali, Himachal Pradesh",
            "Ooty, Tamil Nadu", "Pondicherry", "Coorg, Karnataka", "Mysore, Karnataka",
            "Agra, Uttar Pradesh", "Varanasi, Uttar Pradesh", "Mahabaleshwar, Maharashtra", "Lonavala, Maharashtra",
            "Alibaug, Maharashtra", "Andaman & Nicobar Islands", "Srinagar, Kashmir", "Leh, Ladakh",
            "Chandigarh", "Lucknow, Uttar Pradesh", "Kanpur, Uttar Pradesh", "Indore, Madhya Pradesh"
        ],
        
        date: null,
        showDatePicker: false,
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),
        months: [
          "January", "February", "March", "April", "May", "June", 
          "July", "August", "September", "October", "November", "December"
        ],
        
        get daysInMonth() {
            return new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
        },
        get firstDayOfMonth() {
            return new Date(this.currentYear, this.currentMonth, 1).getDay();
        },
        get realMonthIndex() {
            return ((this.currentMonth % 12) + 12) % 12;
        },
        get realYear() {
            return this.currentYear + Math.floor(this.currentMonth / 12);
        },
        
        handleDateSelect(day) {
            this.date = new Date(this.realYear, this.realMonthIndex, day);
            this.showDatePicker = false;
        },
        
        get formattedDate() {
            if (!this.date) return '';
            return this.date.toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
        },
        get isoDate() {
            // For the hidden input to send to backend (YYYY-MM-DD)
            if (!this.date) return '';
            const offset = this.date.getTimezoneOffset()
            const yourDate = new Date(this.date.getTime() - (offset*60*1000))
            return yourDate.toISOString().split('T')[0];
        },

        get displayLocations() {
            if (this.apiLocations.length > 0) return this.apiLocations;
            if (this.isSearching) return [];
            if (this.locationQuery.length > 0 && this.locationQuery.length < 3) {
                return this.indianLocations.filter(l => l.toLowerCase().includes(this.locationQuery.toLowerCase())).slice(0, 5);
            }
            if (this.locationQuery.length >= 3) {
                return this.indianLocations.filter(l => l.toLowerCase().includes(this.locationQuery.toLowerCase())).slice(0, 5);
            }
            return this.indianLocations.slice(0, 6);
        },

        async fetchLocations() {
            if (this.locationQuery.length < 3) {
                this.apiLocations = [];
                return;
            }
            this.isSearching = true;
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.locationQuery)}&countrycodes=in&limit=5&addressdetails=1`);
                const data = await res.json();
                const places = data.map(item => {
                    const city = item.address.city || item.address.town || item.address.village || item.address.county;
                    const state = item.address.state;
                    if (city && state) return `${city}, ${state}`;
                    return item.display_name.split(',').slice(0, 2).join(',');
                });
                this.apiLocations = [...new Set(places)];
            } catch(e) {
                console.error(e);
            } finally {
                this.isSearching = false;
            }
        },
        
        init() {
            this.$watch('locationQuery', (val) => {
                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    this.fetchLocations();
                }, 500);
            });
        }
    }));
});

Alpine.start();
