    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
    var data = google.visualization.arrayToDataTable([
    ['Data', 'Count'],
        ['Active Posts', act_post_count],
        ['Draft Posts', draft_post_count],
        ['Categories', cat_count],
        ['Users', user_count],
        ['Subscribers', sub_User_count],
        ['Comments', com_count],
        ['Unapproved Comments', unapp_com_count]
    ]);

    var options = {
    chart: {
    title: '',
    subtitle: '',
}
};

    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
}