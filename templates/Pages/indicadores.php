<!-- TOPO
================================================== -->
<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6"
    data-background="<?= WWW; ?>/site/img/banner/page-title.webp">
    <div class="container position-unset">
        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">
            <div class="row">
                <div class="col-md-12">
                    <h1>Indicadores e Impacto Social</h1>
                </div>
                <div class="col-md-12">
                    <ul class="ps-0">
                        <li><a href="/home">Home</a></li>
                        <li><a href="#!">Indicadores</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INDICADORES
================================================== -->
<section class="bg-light">
    <div class="container">
        <div class="text-center mb-2-9 mb-lg-6 wow fadeIn" data-wow-delay="100ms">
            <span class="text-secondary mb-2 d-block fw-bold text-uppercase">Nossas Estatísticas</span>
            <h2 class="mb-0 h1">Perfil dos Participantes</h2>
            <p class="mt-4 mx-auto w-md-75">Transparência e dados sobre o impacto das nossas ações na comunidade. Fonte: Assertivos (2026).</p>
        </div>

        <div class="row mt-n4">
            <!-- Gênero -->
            <div class="col-lg-6 mb-4 wow fadeIn" data-wow-delay="200ms">
                <div class="card border-0 box-shadow-large h-100">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="h5 mb-0"><i class="fas fa-venus-mars me-2"></i>Gênero</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Cor/Etnia -->
            <div class="col-lg-6 mb-4 wow fadeIn" data-wow-delay="300ms">
                <div class="card border-0 box-shadow-large h-100">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="h5 mb-0"><i class="fas fa-users me-2"></i>Cor / Etnia</h4>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <canvas id="ethnicityPieChart"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="ethnicityBarChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado Civil -->
            <div class="col-12 mb-4 wow fadeIn" data-wow-delay="400ms">
                <div class="card border-0 box-shadow-large">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="h5 mb-0"><i class="fas fa-heart me-2"></i>Estado Civil</h4>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 col-md-4 col-lg-2 mb-3">
                                <div class="p-3 border rounded bg-light">
                                    <span class="d-block text-primary fw-bold h4 mb-1">70,53%</span>
                                    <small class="text-uppercase fw-bold">Solteiro(a)</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-2 mb-3">
                                <div class="p-3 border rounded bg-light">
                                    <span class="d-block text-primary fw-bold h4 mb-1">11,56%</span>
                                    <small class="text-uppercase fw-bold">Não informado</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-2 mb-3">
                                <div class="p-3 border rounded bg-light">
                                    <span class="d-block text-primary fw-bold h4 mb-1">11,36%</span>
                                    <small class="text-uppercase fw-bold">Casado(a)</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-2 mb-3">
                                <div class="p-3 border rounded bg-light">
                                    <span class="d-block text-primary fw-bold h4 mb-1">2,92%</span>
                                    <small class="text-uppercase fw-bold">União Estável</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-2 mb-3">
                                <div class="p-3 border rounded bg-light">
                                    <span class="d-block text-primary fw-bold h4 mb-1">2,43%</span>
                                    <small class="text-uppercase fw-bold">Divorciado(a)</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-2 mb-3">
                                <div class="p-3 border rounded bg-light">
                                    <span class="d-block text-primary fw-bold h4 mb-1">1,20%</span>
                                    <small class="text-uppercase fw-bold">Viúvo</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Programas Sociais -->
            <div class="col-12 mb-4 wow fadeIn" data-wow-delay="500ms">
                <div class="card border-0 box-shadow-large">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="h5 mb-0"><i class="fas fa-hand-holding-heart me-2"></i>Programas Sociais</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="fw-bold mb-1">Nenhum (59,87%)</label>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 59.87%;" aria-valuenow="59.87" aria-valuemin="0" aria-valuemax="100">59,87%</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="fw-bold mb-1">Bolsa Família (35,58%)</label>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 35.58%;" aria-valuenow="35.58" aria-valuemin="0" aria-valuemax="100">35,58%</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="fw-bold mb-1">BPC (2,33%)</label>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 2.33%;" aria-valuenow="2.33" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small>2,33%</small>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="fw-bold mb-1">Pé de Meia (1,63%)</label>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 1.63%;" aria-valuenow="1.63" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small>1,63%</small>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="fw-bold mb-1">Outros (Tarifa Social, Auxílio Gás)</label>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 0.6%;" aria-valuenow="0.6" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small>0,60%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Scripts para os Gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Cores padrão
        const primaryColor = '#0026a2'; // Azul Instituto
        const secondaryColor = '#ffc107'; // Amarelo
        const chartColors = [
            '#0026a2', '#003eb3', '#0056c4', '#3377d6', '#6699e7', '#99bbf8'
        ];

        // Gráfico de Gênero (Horizontal Bar)
        const ctxGender = document.getElementById('genderChart').getContext('2d');
        new Chart(ctxGender, {
            type: 'bar',
            data: {
                labels: ['Feminino', 'Masculino', 'Não Informado', 'Não Binário'],
                datasets: [{
                    label: 'Percentual (%)',
                    data: [79.10, 16.68, 4.09, 0.13],
                    backgroundColor: primaryColor,
                    borderRadius: 5
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: (context) => context.raw + '%' } }
                },
                scales: {
                    x: { max: 100, ticks: { callback: (value) => value + '%' } }
                }
            }
        });

        // Gráfico de Cor/Etnia (Pie)
        const ctxEthPie = document.getElementById('ethnicityPieChart').getContext('2d');
        new Chart(ctxEthPie, {
            type: 'pie',
            data: {
                labels: ['Pardo', 'Branco', 'Preto', 'Indígena', 'Não Informado', 'Amarelo'],
                datasets: [{
                    data: [65.28, 15.78, 15.78, 0.53, 2.59, 0.03],
                    backgroundColor: chartColors
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12 } }
                }
            }
        });

        // Gráfico de Cor/Etnia (Bar)
        const ctxEthBar = document.getElementById('ethnicityBarChart').getContext('2d');
        new Chart(ctxEthBar, {
            type: 'bar',
            data: {
                labels: ['Pardo', 'Branco', 'Preto', 'N.I.', 'Indíg.', 'Amar.'],
                datasets: [{
                    label: 'Percentual (%)',
                    data: [65.28, 15.78, 15.78, 2.59, 0.53, 0.03],
                    backgroundColor: primaryColor,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, max: 100 }
                }
            }
        });
    });
</script>

<style>
    .card-header.bg-primary {
        background-color: #0026a2 !important;
    }
    .text-primary {
        color: #0026a2 !important;
    }
    .progress-bar.bg-primary {
        background-color: #0026a2 !important;
    }
    .box-shadow-large {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
</style>
