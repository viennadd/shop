<div class="col-md-4"></div>
</div>

</body>
<script src="dist/js/jquery-2.0.3.min.js"></script>
<script src="dist/js/jasny-bootstrap.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
<script>

    var url = window.location.href;
    // Will also work for relative and absolute hrefs
    $('.menu a').filter(function() {
        return this.href == url;
    }).parent().addClass('active');
</script>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: vienna
 * Date: 13-12-7
 * Time: 下午12:09
 */
?>