// needed for likebb and bbtags
const event = (el, event, callback) => {
    
    document.addEventListener(event, function(e){
        const elems = document.querySelectorAll(el);
        const clickedElement = e.target, 
          matchingChild = clickedElement.closest(el);

        for ( let i = 0; i < elems.length; i++ ) {
            // elems[i].addEventListener(event, function(e) {
            //  callback.call(this, e);
            // });
            if ( elems[i] === matchingChild ) {
                callback.call(elems[i], e);
            }
        }
    });
}