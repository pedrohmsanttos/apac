setTimeout(function(){
    var modal = new tingle.modal({
        footer: true,
        stickyFooter: false,
        closeMethods: ['overlay', 'button', 'escape'],
        closeLabel: "Close",
        cssClass: ['custom-class-1', 'custom-class-2'],
        onOpen: function() {
            console.log('modal open');
        },
        onClose: function() {
            console.log('modal closed');
        },
        beforeClose: function() {
            return true; // close the modal
        	return false; // nothing happens
        }
    });

    // set content
    if(modal_content != ''){
      modal.setContent(modal_content);
      modal.open();
    }

}, 3000);
