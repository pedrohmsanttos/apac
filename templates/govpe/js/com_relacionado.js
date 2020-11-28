var contador = 1;

jQuery.noConflict();
(function($)
{
    $(document).ready(function()
    {
        
        $('.tree').treegrid({
          'initialState': 'collapsed',
          'saveState': true,
          expanderExpandedClass: 'glyphicon glyphicon-minus',
            expanderCollapsedClass: 'glyphicon glyphicon-plus'
        });


    });
})(jQuery);