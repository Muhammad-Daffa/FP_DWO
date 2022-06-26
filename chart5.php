<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Chart Berat Pengiriman Per Tahun</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/data.js"></script>
        <script src="https://code.highcharts.com/modules/drilldown.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">ADVENTURE WORKS</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="chart1.php">Kuantitas Per Kategori</a>
                                    <a class="nav-link" href="chart2.php">Pendapatan Per Tahun</a>
                                    <a class="nav-link" href="chart3.php">Pendapatan Tiap Kategori Per Tahun</a>
                                    <a class="nav-link" href="chart4.php">Transaksi Per Wilayah Bagian</a>
                                    <a class="nav-link" href="chart5.php">Berat Pengiriman Tiap Metode Per Tahun</a>
                                    <a class="nav-link" href="chart6.php">Total Transaksi Per Tahun</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Kelompok 15 DWO 2022
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Chart Berat Pengiriman Tiap Metode Per Tahun</h1>
                        <div class="card mb-4">
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-pie me-1"></i>
                                Chart Total Berat Berdasarkan Metode Pengiriman Pada Tiap Tahunnya
                            </div>
                            <?php
                                        $host       = "localhost";
                                        $user       = "root";
                                        $password   = "";
                                        $database   = "db_adventure_olap";
                                        $mysqli     = mysqli_connect($host, $user, $password, $database);
                                        // Chart Pertama 

                                        $sql = "SELECT SUM(freight) AS total FROM fact_shipment";
                                        $tot = mysqli_query($mysqli, $sql);
                                        $tot_amount = mysqli_fetch_row($tot);

                                        $sql = "SELECT CONCAT('name:',t.year) as year, CONCAT('y:', SUM(fs.freight)*100/" . $tot_amount[0] .") as y, CONCAT('drilldown:', t.year) as drilldown 
                                        FROM timedimens t
                                        JOIN fact_shipment fs ON (t.time_id = fs.time_id) 
                                        GROUP BY year";
                                        $all_year = mysqli_query($mysqli,$sql);
                                        while($row = mysqli_fetch_all($all_year)) {
                                            $data[] = $row;
                                        }
                                        $json_all_year = json_encode($data);

                                        // Chart Kedua

                                        $sql = "SELECT t.year year, s.ship_name ship_name, SUM(fs.freight) as total
                                        FROM timedimens t
                                        JOIN fact_shipment fs ON (t.time_id = fs.time_id)
                                        JOIN shipment s ON (s.shipmethod_id = fs.shipmethod_id)
                                        GROUP BY year, ship_name";
                                        $det_shipment = mysqli_query($mysqli,$sql);

                                        while ($row = mysqli_fetch_all($det_shipment)) {
                                            $data_det[] = $row;
                                        }

                                        // DATA DRILL DOWN
                                        $i = 0;

                                        // Inisiasi String DATA
                                        $string_data = "";
                                        $string_data .= '{nama:"' . $data_det[0][$i][0] . '", id:"' . $data_det[0][$i][0] . '", data: [';

                                        foreach($data_det[0] as $a){
                                            if($i < count($data_det[0])-1){
                                                if($a[0] != $data_det[0][$i+1][0]){
                                                    $string_data .= '["' . $a[1] . '", ' . $a[2] . ']]},';
                                                    $string_data .= '{name:"' . $data_det[0][$i+1][0] . '", id:"' . $data_det[0][$i+1][0] . '", data: [';
                                                }
                                                else {
                                                    $string_data .= '["' . $a[1] . '", ' . $a[2] . '], ';
                                                }
                                            }
                                            else {
                                                $string_data .= '["' . $a[1] . '", ' . $a[2] . ']]}';
                                            }

                                            $i = $i+1;
                                        }

                                        ?>
                            <div id="chart1"></div>
                        </div>
                        
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Kelompok 15 DWO 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <script type="text/javascript">
            Highcharts.chart('chart1', {
                chart: {
                type: 'pie'
            },
            title: {
                text: 'Persentase Total Berat Dari Tiap Metode Pengirimannya Berdasarkan Tahun'},
                subtitle: {
                    text:'Klik untuk melihat detail jumlah dari setiap tahun'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    },
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    drilldown:{
                        dataLabels: {
                            format:'{point.name}: {point.y:.0f}'                   
                        }
                    },
                    series:{
                        dataLabels: {
                            format:'{point.name}: {point.y:.2f}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                },
                series: [
                    {
                        name: "Tahun",
                        colorByPoint: true,
                        data:
                            <?php
                            $datanya = $json_all_year;
                            $data1 = str_replace('["', '{"',$datanya) ;
                            $data2 = str_replace('"]', '"}',$data1) ;
                            $data3 = str_replace('[[', '[', $data2);
                            $data4 = str_replace(']]', ']', $data3);
                            $data5 = str_replace(':', '" : "', $data4);
                            $data6 = str_replace('"name"', 'name', $data5);
                            $data7 = str_replace('"drilldown"', 'drilldown', $data6);
                            $data8 = str_replace('"y"', 'y', $data7);
                            $data9 = str_replace('",', ',', $data8);
                            $data10 = str_replace(',y', '",y', $data9);
                            $data11 = str_replace(',y : "', ',y : ', $data10);
                            echo $data11;
                            ?>
                    }
                ],
                drilldown: {
                    series: [
                        <?php
                        echo $string_data;
                        ?>
                    ]
                }
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="assets/demo/chart-pie-demo.js"></script>
    </body>
</html>
