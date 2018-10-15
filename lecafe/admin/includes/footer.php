</div><br><br> 
<div class="col-md-12 text-center">&copy; Copyright 2018 lecafe</div>

<script>
    function updateSizes(){
        var sizeString = '';
        for(var i=1;i<12;i++){
            if(jQuery('#size'+i).val() != ''){
                sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
            }
        }
        jQuery('#sizes').val(sizeString);
    }
</script>

    </body>
</html>