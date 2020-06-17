<!doctype html> 
<html lang="it"> 
<head> 
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta property="og:title" content="Covid 19 API Italia">
	<meta property="og:description" content="API in formato JSON con i dati forniti dalla Protezione Civile relativi sul contagio da COVID-19 nelle regioni e province Italiane.">
	<meta property="og:image" content="http://www.covid19api.it/img/share.png">
	<meta property="og:image:type" content="image/jpeg" />
	<meta property="og:image:width" content="1114" />
	<meta property="og:image:height" content="509" />
	<meta property="og:url" content="http://www.covid19api.it/">
		<link rel="stylesheet" href="css/bootsrap-css/bootstrap.min.css">
		<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

	<link rel="shortcut icon" href="img/icona.ico" />
	<title>API COVID-19</title> 

	<script type="text/javascript">
		function CopyToClipboard(containerid) {
		  if (window.getSelection) {
		    var range = document.createRange();
		    range.selectNode(document.getElementById(containerid));
		    window.getSelection().addRange(range);
		    document.execCommand("copy");
		    window.getSelection().removeAllRanges(); 
		    console.log("Copy!!")
		  }
		}			
	</script>
</head> 

<body>

	<?php require($_SERVER["DOCUMENT_ROOT"].'/header.php'); ?>


	<div class="container-fluid" id="ContainerTitle">
		<div class="container-fluid" id="ContainerTitle_Center">
			<div class="row-1">
	    		<div class="col-sm-7" id="ContainerTitle_Titolo"><h1>Visualizzazione dei dati COVID-19</h1></div>
	    		<div class="col-sm-9" id="ContainerTitle_Sottotitolo">COVID-JSON-19 è una API JSON gratuita che mette a disposizione i dati del contagio da Sars-COVID-19 in Italia. In questo sito potrete visualizzare anche grafici interattivi sul contagio da COVID-19 su tutto il territorio italiano. Potrete trovare vari indicatori per i parametri visualizzati e le date relative ai dati.</div>
	  		</div>
  		</div>
	</div>



<div class="container-fluid" id="ContainerCenter">

		<div class="container" id="ContainerRegions">
			<div class="row-1">
    			<div class="col Titolo_Center"> Regions </div>
    			<div class="col Sottotitolo_Center">Descrizione</div>
    			<div class="col-md-8" id="Descrizione_Center">L’api restituisce tutti i dati disponibili per regione dal 24/02/2020 alla data odierna.</div>
    			<div class="col Sottotitolo_Center">Parametri</div>
    			<div class="col-md-8" id="Descrizione_Center">
    				<span class="docs">all</span>: se settato a true ci restituisce tutti i dati delle regioni disponibili. <br>
    				single: se settato a true ci restituisce i dati di una sola data, la data specificata nello start_date <br> 
    				<span class="docs">start_date</span>: restituisce i dati a partire dalla data specificata (formato YYYY-MM-DD)<br>
					<span class="docs">end_date</span>: restituisce i dati fino alla data specificata (formato YYYY-MM-DD)<br>
					<span class="docs">region_code</span>: codice ISTAT della regione<br>
					<span class="docs">region_name</span>: denominazione della regione (n.b. ha precedenza su region_code)<br>
                    
                    Se omessi, start_date e end_date si setteranno automaticamente alla data più recente, inoltre è possibile specificare in region_code e region_name più di un valore, ogni valore però dev'essere separato da virgola.
                </div>
				<div class="col Sottotitolo_Center">Esempio di utilizzo</div>

				<div class="col" id="Link_Tab"> 
					<button id="button" onclick="CopyToClipboard('LINKRegions')">    
		    			<div id="TestoButton">Copy code</div>
		    			<img id="ImgButton" src="img/logoCopy.png">
					</button>

					<div class="col" id="Link_Tot">GET <a class="nav-link" target="_blank" href="http://www.covid19api.it/regions?start_date=2020-04-04&end_date=2020-04-04&region_code=16" id="LINKRegions"> http://www.covid19api.it/regions?start_date=2020-04-04&ampend_date=2020-04-04&ampregion_code=16 </a></div>					
				</div>


					<div class="col Json">
						[ <br>
							&ensp;&ensp; { <br>
								&emsp;&emsp; “date”: “2020-05-04”, <br>
								&emsp;&emsp; “nation”: “ITA”, <br>
								&emsp;&emsp; “region_code”: “16”, <br>
								&emsp;&emsp; “region_name”: “Puglia”, <br>
								&emsp;&emsp; “latitude”: “41.12559576”, <br>
								&emsp;&emsp; “longitude”: “16.86736689”, <br>
								&emsp;&emsp; “hospitalized_with_symptoms”: “397”, <br>
								&emsp;&emsp; “intensive_care”: “39”, <br>
								&emsp;&emsp; “total_hospitalized”: “436”, <br>
								&emsp;&emsp; “home_isolation”: “2509”, <br>
								&emsp;&emsp; “total_positives”: “2945”, <br>
								&emsp;&emsp; “total_variation_positives”: “-10”, <br>
								&emsp;&emsp; “new_positives”: “9”, <br>
								&emsp;&emsp; “released_cured”: “779”, <br>
								&emsp;&emsp; “total_deaths”: “429”, <br>
								&emsp;&emsp; “total_cases”: “4153”, <br>
								&emsp;&emsp; “swabs”: “67167”, <br>
								&emsp;&emsp; “testes_cases”: “65789” <br>
							&ensp;&ensp; } <br>
						] <br>
					</div>
  			</div>
		</div>


		<div class="container" id="ContainerDistricts">
			<div class="row-1">
    			<div class="col Titolo_Center"> Districts </div>
    			<div class="col Sottotitolo_Center">Descrizione</div>
    			<div class="col-md-8" id="Descrizione_Center">L’api restituisce tutti i dati disponibili per provincia dal 24/02/2020 alla data odierna.</div>
    			<div class="col Sottotitolo_Center">Parametri</div>
    			<div class="col-md-8" id="Descrizione_Center">
    				<span class="docs">all</span>: se settato a true ci restituisce tutti i dati delle province disponibili. <br>
    				<span class="docs">single</span>: se settato a true ci restituisce i dati di una sola data, la data specificata nello start_date <br> 
    				<span class="docs">start_date</span>: restituisce i dati a partire dalla data specificata (formato YYYY-MM-DD)<br>
					<span class="docs">end_date</span>: restituisce i dati fino alla data specificata (formato YYYY-MM-DD)<br>
					<span class="docs">district_code</span>: codice ISTAT delle province<br>
					<span class="docs">district_name</span>: nome abbreviato della provincia<br>
                    Qui start_date, end_date, district_code e district_name hanno lo stesso comportamento che hanno nell'endpoint delle regioni.
                    </div>
				<div class="col Sottotitolo_Center">Esempio di utilizzo</div>

				<div class="col" id="Link_Tab"> 
					<button id="button" onclick="CopyToClipboard('LINKDistricts')">    
		    			<div id="TestoButton">Copy code</div>
		    			<img id="ImgButton" src="img/logoCopy.png">
					</button>

					<div class="col" id="Link_Tot">GET <a class="nav-link" target="_blank" href="http://www.covid19api.it/districts?start_date=2020-04-04&end_date=2020-04-04&district_code=071" id="LINKDistricts"> http://www.covid19api.it/districts?start_date=2020-04-04&ampend_date=2020-04-04&ampdistrict_code=071 </a></div>					
				</div>


					<div class="col Json">
						[ <br>
							&ensp;&ensp; { <br>
								&emsp;&emsp; “date”: “2020-05-04”, <br>
								&emsp;&emsp; “nation”: “ITA”, <br>
								&emsp;&emsp; “region_code”: “16”, <br>
								&emsp;&emsp; “region_name”: “Puglia”, <br>
								&emsp;&emsp; “province_code”: “071”, <br>
								&emsp;&emsp; “province_denomination”: “Foggia”, <br>
								&emsp;&emsp; “province_abbreviation”: “FG”, <br>
								&emsp;&emsp; “latitude”: “41.46226865”, <br>
								&emsp;&emsp; “longitude”: “15.54305094”, <br>
								&emsp;&emsp; “total_cases”: “1070” <br>
							&ensp;&ensp; } <br>
						]
					</div>
  			</div>
		</div>

		<div class="container" id="ContainerFriendly">
			<div class="row-1">
    			<div class="col Titolo_Center"> Friendly URLS </div>
    			<div class="col-md-8" id="Descrizione_Center">
    				Si può utilizzare una forma più human-friendly per entrambi gli endpoint.<br>
					Per l'endpoint delle regioni sarà possibile utilizzare anche la forma friendly per avere i dati di una sola regione, attraverso il nome o il codice ISTAT.<br>
                    Invece per l'endpoint delle province si potrà specificare solo la sigla.<br>
					Ad es. sono validi questi endpoint:
    			</div>

				<div class="col" id="Link_Tab"> 
					<button id="button" onclick="CopyToClipboard('LINKFriendly1')">    
		    			<div id="TestoButton">Copy code one</div>
		    			<img id="ImgButton" src="img/logoCopy.png">
					</button>
					<button id="button" onclick="CopyToClipboard('LINKFriendly2')">    
		    			<div id="TestoButton">Copy code two</div>
		    			<img id="ImgButton" src="img/logoCopy.png">
					</button>
                    <button id="button" onclick="CopyToClipboard('LINKFriendly3')">    
		    			<div id="TestoButton">Copy code three</div>
		    			<img id="ImgButton" src="img/logoCopy.png">
					</button>

					<div class="col" id="Link_Tot">GET <a class="nav-link" target="_blank" href="http://www.covid19api.it/regions/puglia?start_date=2020-04-04&single=true" id="LINKFriendly1"> http://www.covid19api.it/regions/puglia?start_date=2020-04-04&ampsingle=true </a></div>	

					<div class="col" id="Link_Tot">GET <a class="nav-link" target="_blank" href="http://www.covid19api.it/regions/16?start_date=2020-04-04&single=true" id="LINKFriendly2"> http://www.covid19api.it/regions/16?start_date=2020-04-04&ampsingle=true </a></div>	
                    
                    <div class="col" id="Link_Tot">GET <a class="nav-link" target="_blank" href="http://www.covid19api.it/districts/FG?start_date=2020-04-04&single=true" id="LINKFriendly3"> http://www.covid19api.it/districts/FG?start_date=2020-04-04&ampsingle=true </a></div>	
                    
  				</div>
			</div>
		</div>
	</div>

	<?php require($_SERVER["DOCUMENT_ROOT"].'/footer.php'); ?>
	
</body> 

</html>