// Alpine.js component for notifications
window.notificationComponent = function() {
    return {
        show: false,
        message: '',
        type: 'success',
        timer: null,
        
        showNotification(message, type = 'success') {
            this.message = message;
            this.type = type;
            this.show = true;
            
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                this.show = false;
            }, 3000);
        },
        
        closeNotification() {
            this.show = false;
        }
    };
};