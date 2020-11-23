$(function () {
    $ref = window.location.search;
    console.log($ref);
    if ($ref == "") {
        $('#recapStats').show();
        $('.link-li-tables').each(function () {
            $(this).removeClass('active');
        })
        $('#indexStat').addClass('active');
        $('#indexStatMini').addClass('active');
    } else {
        $('#recapStats').hide();
        $page = ['visiteur', 'recherche', 'recherche_wiki', 'message', 'erreur'];
        for (let i = 0; i < 5; i++) {
            $currentPage = $page[i];
            $curPage = "?table=" + $currentPage;
            if ($ref.includes($curPage)) {
                console.log($ref);
                console.log($curPage);
                console.log($currentPage);
                $('.link-li-tables').each(function () {
                    $(this).removeClass('active');
                })
                $('#' + $currentPage).siblings('li').removeClass('active');
                $('#' + $currentPage).addClass('active');
                $('#' + $currentPage + 'Mini').addClass('active');
            }
        }
    }
});