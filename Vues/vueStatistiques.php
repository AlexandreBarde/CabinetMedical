<?php
$this->title = "Statistiques";
?>
<div class="jumbotron jumbotron-fluid jumbotron-header">
    <h1 class="text-center display-3 jumbotron-title">Statistiques</h1>
</div>

<div class="container-fluid">
    <h2 class="display-4 text-center">Âge des patients</h2>
    <div class="row">
        <div class="col-xl-6 offset-xl-3 col-md-8 col-lg-8 offset-lg-2 offset-md-2 col-sm-12">
            <table class="table table-striped">
                <tr>
                    <th class="text-center">Tranche d'âge</th>
                    <th class="text-center">Nombre d'hommes</th>
                    <th class="text-center">Nombre de femmes</th>
                </tr>
                <tr>
                    <td class="text-center">Moins de 25 ans</td>
                    <td class="text-center""><?= $hommeMoins25 ?></td>
                    <td class="text-center""><?= $femmeMoins25 ?></td>
                </tr>
                <tr>
                    <td class="text-center">Entre 25 et 50 ans</td>
                    <td class="text-center""><?= $homme25et50 ?></td>
                    <td class="text-center""><?= $femme25et50 ?></td>
                </tr>
                <tr>
                    <td class="text-center">Plus de 50 ans</td>
                    <td class="text-center""><?= $hommePlus50 ?></td>
                    <td class="text-center""><?= $femmePlus50 ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 offset-xl-3 col-md-8 col-lg-8 offset-lg-2 offset-md-2 col-sm-12">
            <div id="graphique" style="width: 900px; height: 500px;">
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load("current", {packages: ["corechart"]});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Âge', 'Années'],
                            ['Hommes de moins de 25 ans', <?= $hommeMoins25 ?>],
                            ['Femmes de moins de 25 ans', <?= $femmeMoins25 ?>],
                            ['Hommes entre 25 et 50 ans', <?=$homme25et50 ?>],
                            ['Femmes entre 25 et 50 ans', <?= $femme25et50 ?>],
                            ['Hommes plus de 50 ans',     <?= $hommePlus50 ?>],
                            ['Femmes plus de 50 ans',     <?= $femmePlus50 ?>]
                        ]);

                        var options = {
                            pieHole: 0.4
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('graphique'));
                        chart.draw(data, options);
                    }
                </script>
            </div>
        </div>
    </div>
    <h2 class="display-4 text-center">Heures par médecin</h2>
    <div class="row">
        <div class="col-xl-6 offset-xl-3 col-md-8 col-lg-8 offset-lg-2 offset-md-2 col-sm-12">
            <table class="table table-stripped">
                <th class="text-center">Médecin</th>
                <th class="text-center">Nombre d'heures</th>
                <?php foreach ($stats_medecins as $nom => $nbh): ?>
                    <tr>
                        <td class="text-center"><?= $nom ?></td>
                        <td class="text-center"><?= $nbh ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>

