$(document).ready(function() {
            
    $('#hamburger').click(function(){                         
        $('#side-bar').toggleClass('open-sidebar');
        $('#sidebar-overlay').toggleClass('open-sidebar');
        $('#main-body').toggleClass('open-sidebar');
    });
    
    $('#sidebar-overlay').click(function(){                         
        $('#side-bar').toggleClass('open-sidebar');
        $('#sidebar-overlay').toggleClass('open-sidebar');
    });

    function handleHamburger() {

        var md = window.matchMedia("(max-width: 768px)");
        if (md.matches) {                                   
            $('#side-bar').removeClass('open-sidebar');
            $('#sidebar-overlay').removeClass('open-sidebar');
        } else {                
            $('#side-bar').addClass('open-sidebar');
            $('#main-body').addClass('open-sidebar');
        }
        
    }

    handleHamburger();

    function resizedw(){
        handleHamburger();
    }

    var doit;
    window.onresize = function(){
        clearTimeout(doit);
        doit = setTimeout(resizedw, 100);
    };


});