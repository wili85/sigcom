<!--<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">-->
<!--<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>

@stack('before-scripts')
@stack('after-scripts')

<style>
.dataTables_filter {
   display: none;
}
.table.dataTable{
	border-collapse:collapse!important;
}

</style>
@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.afiliacion.box_title'))

@section('breadcrumb')
	<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
        <li class="breadcrumb-item active">Informe de Gesti&oacute;n</li>
		<li class="breadcrumb-item active">
		<select name="anio" id="anio" class="form-control-sm" onchange="recargar()">
			<?php for($i=2021;$i<=date("Y");$i++){?>
			<option value="<?php echo $i?>" <?php if($i==$anio)echo "selected='selected'"?> ><?php echo $i?></option>
			<?php } ?>
		</select>
		</li>
    </ol>
@endsection

@section('content')

    <div class="justify-content-center">
    <!--<div class="container-fluid">-->
    	
		<div class="card" style="margin-top:15px">
			
			<div class="card-header bg-primary">
				<h4 class="card-title mb-0 text-white" style="font-size:24px">Total Pagado</h4>
			</div>
			
            <div class="card-body">

        	<div class="row justify-content-center">
        
        	<div class="col col-sm-12 align-self-center">
            
            <div class="row">
				
				
				<div class="col-md-6 col-lg-6">
				
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top:15px">
						<h4 class="card-title mb-0 text-primary" style="font-size:22px">Meses</h4>
					</div>
					
					<canvas id="stats-doughnut-chart-fac-1" width="100%" class="mb-3"></canvas>
				</div>
				
				<div class="col-md-6 col-lg-6">
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top:15px">
						<h4 class="card-title mb-0 text-primary" style="font-size:22px">Dias del Mes Actual</h4>
					</div>
					
					<canvas id="stats-doughnut-chart-fac-2" width="100%" class="mb-3"></canvas>
				</div>
				
            </div>

        </div><!--col-->
		
		</div>
		</div>
		</div>
		
		
		
		
		<div class="card" style="margin-top:15px;">
			
			<div class="card-header bg-primary">
				<h4 class="card-title mb-0 text-white" style="font-size:24px">Total Pagado Capital y Interes</h4>
			</div>
			
            <div class="card-body">

        	<div class="row justify-content-center">
        
        	<div class="col col-sm-12 align-self-center">
            
            <div class="row">
				
				
				<div class="col-md-6 col-lg-6">
				
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top:15px">
						<h4 class="card-title mb-0 text-primary" style="font-size:22px">Meses</h4>
					</div>
					
					<canvas id="stats-doughnut-chart-fac-vehiculo-1" width="100%" class="mb-3"></canvas>
				</div>
				
				<div class="col-md-6 col-lg-6">
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top:15px">
						<h4 class="card-title mb-0 text-primary" style="font-size:22px">Dias del Mes Actual</h4>
					</div>
					
					<canvas id="stats-doughnut-chart-fac-vehiculo-2" width="100%" class="mb-3"></canvas>
				</div>
				
            </div>

        </div><!--col-->
		
		</div>
		</div>
		</div>
		
		
		
		
		
		<div class="card" style="margin-top:15px;">
			
			<div class="card-header bg-primary">
				<h4 class="card-title mb-0 text-white" style="font-size:24px">Total Capital Prestado e Interes Generado</h4>
			</div>
			
            <div class="card-body">

        	<div class="row justify-content-center">
        
        	<div class="col col-sm-12 align-self-center">
            
            <div class="row">
				
				<div class="col-md-6 col-lg-6">
				
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top:15px">
						<h4 class="card-title mb-0 text-primary" style="font-size:22px">Prestado General</h4>
					</div>
					
					<canvas id="stats-doughnut-chart" height="130" class="mb-3"></canvas>
				</div>
				
				<div class="col-md-6 col-lg-6">
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top:15px">
						<h4 class="card-title mb-0 text-primary" style="font-size:22px">Prestado Mensual</h4>
					</div>
					
					<canvas id="stats-doughnut-chart3" height="130" class="mb-3"></canvas>
				</div>
				
            </div>

        </div><!--col-->
		
		</div>
		</div>
		</div>
		
        <div class="card" style="margin-top:15px;">
			
			<div class="card-header bg-primary">
				<h4 class="card-title mb-0 text-white" style="font-size:24px">Total Capital Pendiente e Interes Generado Pendiente</h4>
			</div>
			
            <div class="card-body">

        	<div class="row justify-content-center">
        
        	<div class="col col-sm-12 align-self-center">
            
            <div class="row">
				
				
				<div class="col-md-6 col-lg-6">
				
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top:15px">
						<h4 class="card-title mb-0 text-primary" style="font-size:22px">Prestado General Pendiente</h4>
					</div>
					
					<canvas id="stats-doughnut-chart2" width="100%" class="mb-3"></canvas>
				</div>
				
				<div class="col-md-6 col-lg-6">
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top:15px">
						<h4 class="card-title mb-0 text-primary" style="font-size:22px">Prestado Mensual Pendiente</h4>
					</div>
					
					<canvas id="stats-doughnut-chart4" width="100%" class="mb-3"></canvas>
				</div>
				
            </div>

        </div><!--col-->
		
		</div>
		</div>
		</div>
		
		<div class="card" style="margin-top:15px;display:none">
			
			<div class="card-header bg-primary">
				<h4 class="card-title mb-0 text-white" style="font-size:24px">Acumulado por Plan</h4>
			</div>
			
            <div class="card-body">

        	<div class="row justify-content-center">
        
        	<div class="col col-sm-12 align-self-center">
            
            <div class="row">
				
				
				<div class="col-md-12 col-lg-12">
				
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top:15px">
						<h4 class="card-title mb-0 text-primary" style="font-size:22px">Pagado</h4>
					</div>
					
					<canvas id="stats-doughnut-chart5" height="80" class="mb-3"></canvas>
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top:15px">
						<h4 class="card-title mb-0 text-primary" style="font-size:22px">Pendiente</h4>
					</div>
					
					<canvas id="stats-doughnut-chart6" height="80" class="mb-3"></canvas>
					
				</div>
				
            </div>

        </div><!--col-->
		
		</div>
		</div>
		</div>
		
		<div class="card" style="margin-top:15px;display:none">
			
			<div class="card-header bg-primary">
				<h4 class="card-title mb-0 text-white" style="font-size:24px">Acumulado por Persona</h4>
			</div>
			
            <div class="card-body">

        	<div class="row justify-content-center">
        
        	<div class="col col-sm-12 align-self-center">
            
            <div class="row">
				
				
				<div class="col-md-12 col-lg-12">
				
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top:15px">
						<h4 class="card-title mb-0 text-primary" style="font-size:22px">Pagado</h4>
					</div>
					
					<canvas id="stats-doughnut-chart7" height="80" class="mb-3"></canvas>
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top:15px">
						<h4 class="card-title mb-0 text-primary" style="font-size:22px">Pendiente</h4>
					</div>
					
					<canvas id="stats-doughnut-chart8" height="80" class="mb-3"></canvas>
					
				</div>
				
            </div>

        </div><!--col-->
		
    </div><!--row-->
@endsection

@push('after-scripts')
{!! script(asset('js/afiliacion_new.js')) !!}
<script>

	function recargar(){
		var anio = $("#anio").val();
		window.location.href="/grafico/all/"+anio;
	}
	
	function formato_miles(numero){
		
		return parseFloat(numero).toFixed(2).replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1.$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
	}

	$(function() {
		
		new Chart(document.getElementById("stats-doughnut-chart-fac-1"), {
			type: 'bar',
			data: {!! $chartDataFacMes !!},
			options: {
				responsive: true,
				legend: {
					position: 'bottom',
					display:false
				},
				scales: {
                    yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
								callback: function(valor, index, valores) {
								  return formato_miles(valor)
								}
                            }
                        }]
                },
				tooltips: {
					callbacks: {
						label: function(tooltipItem, chart){
							var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
							return datasetLabel + " " + formato_miles(tooltipItem.yLabel);
						}
					}
				}
	 
			}
		});
		
		new Chart(document.getElementById("stats-doughnut-chart-fac-2"), {
			type: 'bar',
			data: {!! $chartDataFacDia !!},
			options: {
				responsive: true,
				legend: {
					position: 'bottom',
					display:false
				},
				scales: {
                    yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
								callback: function(valor, index, valores) {
								  return formato_miles(valor)
								}
                            }
                        }]
                },
				tooltips: {
					callbacks: {
						label: function(tooltipItem, chart){
							var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
							return datasetLabel + " " + formato_miles(tooltipItem.yLabel);
						}
					}
				}
	 
			}
		});
		
		
		new Chart(document.getElementById("stats-doughnut-chart-fac-vehiculo-1"), {
			type: 'bar',
			data: {!! $chartDataPagosCapitalInteresMes !!},
			options: {
				responsive: true,
				legend: {
					position: 'bottom'
				},
				scales: {
                    yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
								callback: function(valor, index, valores) {
								  return formato_miles(valor)
								}
                            }
                        }]
                },
				tooltips: {
					callbacks: {
						label: function(tooltipItem, chart){
							var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
							return datasetLabel + " " + formato_miles(tooltipItem.yLabel);
						}
					}
				}
	 
			}
		});
		
		new Chart(document.getElementById("stats-doughnut-chart-fac-vehiculo-2"), {
			type: 'bar',
			data: {!! $chartDataPagosCapitalInteresDia !!},
			options: {
				responsive: true,
				legend: {
					position: 'bottom'
				},
				scales: {
                    yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
								callback: function(valor, index, valores) {
								  return formato_miles(valor)
								}
                            }
                        }]
                },
				tooltips: {
					callbacks: {
						label: function(tooltipItem, chart){
							var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
							return datasetLabel + " " + formato_miles(tooltipItem.yLabel);
						}
					}
				}
	 
			}
		});
		
		
		new Chart(document.getElementById("stats-doughnut-chart"), {
			//type: 'doughnut',
			type: 'pie',
			data: {!! $chartDataCapitalPrestadoInteresGenerado !!},
			options: {
				legend: {
					position: 'bottom'
				},
				tooltips: {
					callbacks: {
						label: function(tooltipItem, chart){
							var datasetLabel = chart.labels[tooltipItem.index];
							var datasetvalue = chart.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
							return datasetLabel + " " + formato_miles(datasetvalue);
						}
					}
				}
			}
		});
		
		new Chart(document.getElementById("stats-doughnut-chart2"), {
			type: 'pie',
			data: {!! $chartDataCapitalPendienteInteresPendiente !!},
			options: {
				legend: {
					position: 'bottom'
				},
				tooltips: {
					callbacks: {
						label: function(tooltipItem, chart){
							var datasetLabel = chart.labels[tooltipItem.index];
							var datasetvalue = chart.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
							return datasetLabel + " " + formato_miles(datasetvalue);
						}
					}
				}
			}
		});
		
		new Chart(document.getElementById("stats-doughnut-chart3"), {
			type: 'bar',
			data: {!! $chartDataCapitalPrestadoInteresGeneradoMes !!},
			options: {
				responsive: true,
				legend: {
					position: 'bottom'
				},
				scales: {
                    yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
								callback: function(valor, index, valores) {
								  return formato_miles(valor)
								}
                            }
                        }]
                },
				tooltips: {
					callbacks: {
						label: function(tooltipItem, chart){
							var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
							return datasetLabel + " " + formato_miles(tooltipItem.yLabel);
						}
					}
				}
                
			}
		});
		
		new Chart(document.getElementById("stats-doughnut-chart4"), {
			type: 'bar',
			data: {!! $chartDataCapitalPendienteInteresPendienteMes !!},
			options: {
				responsive: true,
				legend: {
					position: 'bottom',
				},
				scales: {
                    yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
								callback: function(valor, index, valores) {
								  return formato_miles(valor)
								}
                            }
                        }]
                },
				tooltips: {
					callbacks: {
						label: function(tooltipItem, chart){
							var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
							return datasetLabel + " " + formato_miles(tooltipItem.yLabel);
						}
					}
				}
	 
			}
		});
		/*
		new Chart(document.getElementById("stats-doughnut-chart5"), {
			type: 'bar',
			data: {! $chartDataFacturado3 !!},
			options: {
				responsive: true,
				legend: {
					position: 'bottom',
					align:'start',
					labels: {
						fontSize: 8,
						boxWidth:20,
					}
				},
				scales: {
                    yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                            }
                        }]
                },
	 
			}
		});
		
		new Chart(document.getElementById("stats-doughnut-chart6"), {
			type: 'bar',
			data: {! $chartDataPendiente3 !!},
			options: {
				responsive: true,
				legend: {
					position: 'bottom',
					align:'start',
					labels: {
						fontSize: 8,
						boxWidth:20,
					}
				},
				scales: {
                    yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                            }
                        }]
                },
	 
			}
		});
		
		new Chart(document.getElementById("stats-doughnut-chart7"), {
			type: 'bar',
			data: {! $chartDataFacturado4 !!},
			options: {
				responsive: true,
				legend: {
					position: 'bottom',
					align:'start',
					labels: {
						fontSize: 8,
						boxWidth:20,
					}
				},
				scales: {
                    yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                            }
                        }]
                },
	 
			}
		});
		
		new Chart(document.getElementById("stats-doughnut-chart8"), {
			type: 'bar',
			data: {! $chartDataPendiente4 !!},
			options: {
				responsive: true,
				legend: {
					position: 'bottom',
					align:'start',
					labels: {
						fontSize: 8,
						boxWidth:20,
					}
				},
				scales: {
                    yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                            }
                        }]
                },
	 
			}
		});
		*/
		
		
	});
</script>
    @if(config('access.captcha.contact'))
        @captchaScripts
    @endif
@endpush