jQuery(document).ready(function () {
    jQuery(".first_parent > a").click(function () {
        if(jQuery(this).hasClass("active_cat")){
            jQuery(".active_cat").removeClass("active_cat");
            jQuery(this).find("i").removeClass("fa-chevron-up");
            jQuery(this).find("i").addClass("fa-chevron-down");
            jQuery(this).parent().find("ul").hide(400);
        }else{
            jQuery(".first_parent ul").hide(400);
            jQuery(this).parent().find("ul").show(400);
            jQuery(".active_cat i").removeClass("fa-chevron-up");
            jQuery(".active_cat i").addClass("fa-chevron-down");
            jQuery(".active_cat").removeClass("active_cat");
            jQuery(this).addClass("active_cat");
            jQuery(this).find("i").removeClass("fa-chevron-down");
            jQuery(this).find("i").addClass("fa-chevron-up");
        }
    });
});
