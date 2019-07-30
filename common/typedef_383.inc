<?php
// Defitinition of component types IDs for project 383 -> 'ITS' on the production database
$projectID = 383;
$compType = array(
				'OBFPC' => array("id" => 426 ,"name" =>  "Outer Barrel Flexible Printed Circuit"),
				'IBFPC' => array("id" => 428 ,"name" =>  "Inner Barrel Flexible Printed Circuit"),	
				'ACHP' => array("id" => 367 ,"name" =>  "ALPIDEB Chip"),					
				'OBHIC' => array("id" => 427 ,"name" =>  "Outer Barrel Hybrid Integrated Circuit"),		
				'IBHIC' => array("id" => 429 ,"name" =>  "Inner Barrel Hybrid Integrated Circuit"),									
				'CHPTR' => array("id" => 387 ,"name" =>  "Tray containing up to 23 ALPIDEB chips"),
				'ABWFR' => array("id" => 388 ,"name" =>  "CMOS Wafer containing 46 ALPIDEB Circuits"),
				'BOBFPC' => array("id" => 548 ,"name" =>  "Blank Outer Barrel Flexible Printed Circuit"),
				'BOBFPCL' => array("id" => 549 ,"name" =>  "Lot of Blank Outer Barrel Flexible Printed Circuits"),
				'MLHSL' => array("id" => 495 ,"name" =>  "Middle Layer Half-Stave Lower"),
				'MLHSU' => array("id" => 513 ,"name" =>  "Middle Layer Half-Stave Upper"),
				'OLHSL' => array("id" => 514 ,"name" =>  "Outer Layer Half-Stave Lower"),
				'OLHSU' => array("id" => 515 ,"name" =>  "Outer Layer Half-Stave Upper"),
				
				
		  );
$actType = array(
 			'OBHICASS' => array( "id" => 542, 
 								 "name" => "OB HIC Assembly",
 							     "location" => array(
  													"CERN" => array("ID" => 382, "Name" => "European Organization for Nuclear Research (CERN)"),
  													"WUHAN" => array("ID" =>387, "Name" => "Central China Normal University"),
  													"BARI" => array("ID" =>383, "Name" => "Sezione INFN Bari"),													
  													"LIVERPOOL" => array("ID" =>384, "Name" => "University of Liverpool"),	
													"STRASBOURG" => array("ID" =>385, "Name" => "Institut Pluridisciplinaire Hubert Curien (IPHC), Universite de Strasbourg, CNRS-IN2P3"),													
													"PUSAN" => array("ID" =>386, "Name" => "Department of Physics, Pusan National University"),													
  												)
 							 ),
  			'IBHICASS' => array( "id" => 541, 
  								 "name" => "IB HIC Assembly",
  							     "location" => array(
  													"CERN" => array("ID" => 381, "Name" => "European Organization for Nuclear Research (CERN)"),
  												)
  							 ),
  			'CHPTHINDIC' => array( "id" => 507, 
  								 "name" => "ALPIDEB Wafer Thinning and Dicing",
  							     "location" => array(
  													"Furex" => array("ID" => 294, "Name" => "Furex, 283 Sandan-ro, Danwon-gu, Ansan-si, Gyeonggi-do"),
  												)
  							 ),
  			'OBHICQUALTEST' => array( "id" => 601, 
 							     "name" => "OB HIC Qualification Test",
 							     "location" => array(
  													"CERN" => array("ID" => 444, "Name" => "European Organization for Nuclear Research (CERN)"),
  													"WUHAN" => array("ID" =>441, "Name" => "Central China Normal University"),
  													"BARI" => array("ID" =>461, "Name" => "Sezione INFN Bari"),													
  													"LIVERPOOL" => array("ID" =>446, "Name" => "University of Liverpool"),	
													"STRASBOURG" => array("ID" =>445, "Name" => "Institut Pluridisciplinaire Hubert Curien (IPHC), Universite de Strasbourg, CNRS-IN2P3"),													
													"PUSAN" => array("ID" =>442, "Name" => "Department of Physics, Pusan National University"),													
  												)
 							 ),
 			'IBHICQUALTEST' => array( "id" => 621, 
 							     "name" => "IB HIC Qualification Test",
 							     "location" => array(
  													"CERN" => array("ID" => 481, "Name" => "European Organization for Nuclear Research (CERN)"),
  																										
  												)
 							 ),
			'MLOLCOMPREC' => array( "id" => 721, 
 							     "name" => "ML OL Mechanical Component Reception",
 							     "location" => array(
  													"CERN" => array("ID" => 581, "Name" => "European Organization for Nuclear Research (CERN), Geneva"),
  													"FRASCATI" => array("ID" => 584, "Name" => "INFN e Laboratori Nazionali di Frascati, Frascati"),
  													"LBNL" => array("ID" => 582, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  													"NIKHEF" => array("ID" => 585, "Name" => "Nikhef, National institute for subatomic physics, Amsterdam"),
  													"DARESBURY" => array("ID" => 586, "Name" => "STFC Daresbury Laboratory, Daresbury"),
  													"TURIN" => array("ID" => 583, "Name" => "Sezione INFN, Turin"),
  																										
  												)
 							 ),
 			'CHPTESTANALYSIS' => array( "id" => 521, 
 							     "name" => "ALPIDEB Chip Testing Analysis",
 							     "location" => array(
  													"CERN" => array("ID" => 361, "Name" => "European Organization for Nuclear Research (CERN)"),
  																										
  												)
 							 ), 
            'OBHICFASTPWRTEST' => array( "id" => 801, 
 							     "name" => "OB HIC Fast Power Test",
 							     "location" => array(
  													"CERN" => array("ID" => 681, "Name" => "European Organization for Nuclear Research (CERN)"),
  													"LNF" => array("ID" => 682, "Name" => "INFN e Laboratori Nazionali di Frascati, Frascati"),
  													"LBNL" => array("ID" => 683, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  													"NIKHEF" => array("ID" => 684, "Name" => "Nikhef, National institute for subatomic physics, Amsterdam"),
  													"DARESBURY" => array("ID" => 685, "Name" => "STFC Daresbury Laboratory, Daresbury"),
  													"TURIN" => array("ID" => 686, "Name" => "Sezione INFN, Turin"),
  																										
  												)
 							 ),
 	    'OBHICENDUTEST' => array( "id" => 661, 
 							     "name" => "OB HIC Endurance Test",
 							     "location" => array(
  													"CERN" => array("ID" => 523, "Name" => "European Organization for Nuclear Research (CERN)"),
  													"WUHAN" => array("ID" =>521, "Name" => "Central China Normal University"),
  													"BARI" => array("ID" =>525, "Name" => "Sezione INFN Bari"),													
  													"LIVERPOOL" => array("ID" =>526, "Name" => "University of Liverpool"),	
													"STRASBOURG" => array("ID" =>524, "Name" => "Institut Pluridisciplinaire Hubert Curien (IPHC), Universite de Strasbourg, CNRS-IN2P3"),													
													"PUSAN" => array("ID" =>522, "Name" => "Department of Physics, Pusan National University"),													
  												)
  							),
 	    'OBHICRECTEST' => array( "id" => 681, 
 							     "name" => "OB HIC Reception Test",
 							     "location" => array(
  													"CERN" => array("ID" => 541, "Name" => "European Organization for Nuclear Research (CERN)"),
  													"LNF" => array("ID" => 542, "Name" => "INFN e Laboratori Nazionali di Frascati, Frascati"),
  													"LBNL" => array("ID" => 543, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  													"NIKHEF" => array("ID" => 544, "Name" => "Nikhef, National institute for subatomic physics, Amsterdam"),
  													"DARESBURY" => array("ID" => 545, "Name" => "STFC Daresbury Laboratory, Daresbury"),
  													"TURIN" => array("ID" => 546, "Name" => "Sezione INFN, Turin"),
  																										
  												)
  							),
 	    'OBHICIMPTEST' => array( "id" => 901, 
 							     "name" => "OB-HIC Impedance Test",
 							     "location" => array(
  													"CERN" => array("ID" => 821, "Name" => "European Organization for Nuclear Research (CERN)"),
  													"WUHAN" => array("ID" =>825, "Name" => "Central China Normal University"),
  													"BARI" => array("ID" =>823, "Name" => "Sezione INFN Bari"),													
  													"LIVERPOOL" => array("ID" =>824, "Name" => "University of Liverpool"),	
													"STRASBOURG" => array("ID" =>801, "Name" => "Institut Pluridisciplinaire Hubert Curien (IPHC), Universite de Strasbourg, CNRS-IN2P3"),													
													"PUSAN" => array("ID" =>822, "Name" => "Department of Physics, Pusan National University"),													
  												)
  							),
 	    'OBHICTABCUT' => array( "id" => 742, 
 							     "name" => "OB-HIC TAB cut",
 							     "location" => array(
  													"LNF" => array("ID" => 608, "Name" => "INFN e Laboratori Nazionali di Frascati, Frascati"),
  													"LBNL" => array("ID" => 609, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  													"NIKHEF" => array("ID" => 610, "Name" => "Nikhef, National institute for subatomic physics, Amsterdam"),
  													"DARESBURY" => array("ID" => 607, "Name" => "STFC Daresbury Laboratory, Daresbury"),
  													"TURIN" => array("ID" => 606, "Name" => "Sezione INFN, Turin"),
  																										
  												)
  							),
 	    'OBHICONMLCPPWRTEST' => array( "id" => 752, 
 							     "name" => "OB-HIC on ML-CP power test",
 							     "location" => array(
  													"LBNL" => array("ID" => 635, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  																										
  												)
  							),
 	    'OBHICONOLCPPWRTEST' => array( "id" => 751, 
 							     "name" => "OB-HIC on OL-CP power test",
 							     "location" => array(
  													"LNF" => array("ID" => 632, "Name" => "INFN e Laboratori Nazionali di Frascati, Frascati"),
  													"NIKHEF" => array("ID" => 633, "Name" => "Nikhef, National institute for subatomic physics, Amsterdam"),
  													"DARESBURY" => array("ID" => 634, "Name" => "STFC Daresbury Laboratory, Daresbury"),
  													"TURIN" => array("ID" => 631, "Name" => "Sezione INFN, Turin"),
  																										
  												)
  							),
 	    'OBHICREC' => array( "id" => 1041, 
 							     "name" => "Outer Barrel HIC Reception",
 							     "location" => array(
  													"BARI" => array("ID" =>966, "Name" => "Sezione INFN Bari"),													
  													"LNF" => array("ID" => 962, "Name" => "INFN e Laboratori Nazionali di Frascati, Frascati"),
  													"LBNL" => array("ID" => 965, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  													"NIKHEF" => array("ID" => 963, "Name" => "Nikhef, National institute for subatomic physics, Amsterdam"),
  													"DARESBURY" => array("ID" => 964, "Name" => "STFC Daresbury Laboratory, Daresbury"),
  													"TURIN" => array("ID" => 961, "Name" => "Sezione INFN, Turin"),
  																										
  												)
  							),
 	    'OBHICSHIP' => array( "id" => 1042, 
 							     "name" => "Outer Barrel HIC Shipment",
 							     "location" => array(
  													"CERN" => array("ID" => 967, "Name" => "European Organization for Nuclear Research (CERN)"),
  													"WUHAN" => array("ID" =>972, "Name" => "Central China Normal University"),
  													"BARI" => array("ID" =>969, "Name" => "Sezione INFN Bari"),													
  													"LIVERPOOL" => array("ID" =>970, "Name" => "University of Liverpool"),	
													"STRASBOURG" => array("ID" =>971, "Name" => "Institut Pluridisciplinaire Hubert Curien (IPHC), Universite de Strasbourg, CNRS-IN2P3"),	"PUSAN" => array("ID" =>968, "Name" => "Department of Physics, Pusan National University"),													
  												)
  							),
  							 
        'IBSTAVEQUALTEST' => array( "id" => 941, 
 							     "name" => "Qualification Test of the IB Stave",
 							     "location" => array(
  													"CERN" => array("ID" => 861, "Name" => "European Organization for Nuclear Research (CERN)"),
  												)
  							),
        'MLHSQUALTEST' => array( "id" => 921, 
 							     "name" => "Qualification test of ML half-stave",
 							     "location" => array(
                                                    "CERN" => array("ID" => 842, "Name" => "European Organization for Nuclear Research (CERN)"),
  													"LBNL" => array("ID" => 941, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  																										
  												)
  							),
        'MLSTVQUALTEST' => array( "id" => 1161, 
 							     "name" => "Test of the ML HS after mounting on the stave",
 							     "location" => array(
                                                    "CERN" => array("ID" => 1122, "Name" => "European Organization for Nuclear Research (CERN)"),
  													"LBNL" => array("ID" => 1121, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  																										
  												)
  							),
        'OLHSQUALTEST' => array( "id" => 881, 
 							     "name" => "OL HS Qualification Test",
 							     "location" => array(
  													"LNF" => array("ID" => 782, "Name" => "INFN e Laboratori Nazionali di Frascati, Frascati"),
  													"CERN" => array("ID" => 781, "Name" => "European Organization for Nuclear Research (CERN)"),
  													"NIKHEF" => array("ID" => 784, "Name" => "Nikhef, National institute for subatomic physics, Amsterdam"),
  													"DARESBURY" => array("ID" => 785, "Name" => "STFC Daresbury Laboratory, Daresbury"),
  													"TURIN" => array("ID" => 786, "Name" => "Sezione INFN, Turin"),
  																										
  												)
  							),
        'OLSTVQUALTEST' => array( "id" => 1141, 
 							     "name" => "OL Stave Qualification Test",
 							     "location" => array(
  													"LNF" => array("ID" => 1104, "Name" => "INFN e Laboratori Nazionali di Frascati, Frascati"),
  													"CERN" => array("ID" => 1105, "Name" => "European Organization for Nuclear Research (CERN)"),
  													"NIKHEF" => array("ID" => 1103, "Name" => "Nikhef, National institute for subatomic physics, Amsterdam"),
  													"DARESBURY" => array("ID" => 1102, "Name" => "STFC Daresbury Laboratory, Daresbury"),
  													"TURIN" => array("ID" => 1101, "Name" => "Sezione INFN, Turin"),
  																										
  												)
  							),
        'MLSTVSTORESHIP' => array( "id" => 765, 
 							     "name" => "ML-Stave storage and shipment",
 							     "location" => array(
  													"LBNL" => array("ID" => 666, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  																										
  												)
  							),
        'MLSTVFINALMTRLGY' => array( "id" => 758, 
 							     "name" => "ML-Stave final metrology",
 							     "location" => array(
  													"LBNL" => array("ID" => 650, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  																										
  												)
  							),
        'OLSTVFINALMTRLGY' => array( "id" => 757, 
 							     "name" => "OL-Stave final metrology",
 							     "location" => array(
  													"LNF" => array("ID" => 646, "Name" => "INFN e Laboratori Nazionali di Frascati, Frascati"),
  													"NIKHEF" => array("ID" => 648, "Name" => "Nikhef, National institute for subatomic physics, Amsterdam"),
  													"DARESBURY" => array("ID" => 649, "Name" => "STFC Daresbury Laboratory, Daresbury"),
  													"TURIN" => array("ID" => 647, "Name" => "Sezione INFN, Turin"),
  																										
  												)
  							),
        'MLPBBBFOLD' => array( "id" => 764, 
 							     "name" => "ML-PBs and ML-BBs folding for ML-Stave",
 							     "location" => array(
  													"LBNL" => array("ID" => 665, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  																										
  												)
  							),
        'OLPBBBFOLD' => array( "id" => 763, 
 							     "name" => "OL-PBs and OL-BBs folding for OL-Stave",
 							     "location" => array(
  													"LNF" => array("ID" => 661, "Name" => "INFN e Laboratori Nazionali di Frascati, Frascati"),
  													"NIKHEF" => array("ID" => 663, "Name" => "Nikhef, National institute for subatomic physics, Amsterdam"),
  													"DARESBURY" => array("ID" => 664, "Name" => "STFC Daresbury Laboratory, Daresbury"),
  													"TURIN" => array("ID" => 662, "Name" => "Sezione INFN, Turin"),
  																										
  												)
  							),
  	'MLHSLOASS' => array( "id" => 747, 
 							     "name" => "ML-HS-Lower assembly",
 							     "location" => array(
  													"LBNL" => array("ID" => 624, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  																										
  												)
  							),
  	'MLHSUPASS' => array( "id" => 748, 
 							     "name" => "ML-HS-Upper assembly",
 							     "location" => array(
  													"LBNL" => array("ID" => 625, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  																										
  												)
  							),
  	'MLSTVASS' => array( "id" => 756, 
 							     "name" => "ML-Stave w/o PB assembly",
 							     "location" => array(
  													"LBNL" => array("ID" => 645, "Name" => "Lawrence Berkeley National Laboratory, Berkeley, California"),
  																										
  												)
  							),
  	'OLHSLOASS' => array( "id" => 745, 
 							     "name" => "OL-HS-Lower assembly",
 							     "location" => array(
  													"LNF" => array("ID" => 618, "Name" => "INFN e Laboratori Nazionali di Frascati, Frascati"),
  													"NIKHEF" => array("ID" => 619, "Name" => "Nikhef, National institute for subatomic physics, Amsterdam"),
  													"DARESBURY" => array("ID" => 675, "Name" => "STFC Daresbury Laboratory, Daresbury"),
  													"TURIN" => array("ID" => 616, "Name" => "Sezione INFN, Turin"),
  																										
  												)
  							),
  	'OLHSUPASS' => array( "id" => 746, 
 							     "name" => "OL-HS-Upper assembly",
 							     "location" => array(
  													"LNF" => array("ID" => 622, "Name" => "INFN e Laboratori Nazionali di Frascati, Frascati"),
  													"NIKHEF" => array("ID" => 623, "Name" => "Nikhef, National institute for subatomic physics, Amsterdam"),
  													"DARESBURY" => array("ID" => 676, "Name" => "STFC Daresbury Laboratory, Daresbury"),
  													"TURIN" => array("ID" => 620, "Name" => "Sezione INFN, Turin"),
  																										
  												)
  							),
  	'OLSTVASS' => array( "id" => 755, 
 							     "name" => "OL-Stave w/o PB assembly",
 							     "location" => array(
  													"LNF" => array("ID" => 641, "Name" => "INFN e Laboratori Nazionali di Frascati, Frascati"),
  													"NIKHEF" => array("ID" => 643, "Name" => "Nikhef, National institute for subatomic physics, Amsterdam"),
  													"DARESBURY" => array("ID" => 644, "Name" => "STFC Daresbury Laboratory, Daresbury"),
  													"TURIN" => array("ID" => 642, "Name" => "Sezione INFN, Turin"),
  																										
  												)
  							),
  	'MLSTVRECTEST' => array( "id" => 1202, 
 							     "name" => "ML Stave Reception Test",
 							     "location" => array(
  													"CERN" => array("ID" => 1182, "Name" => "European Organization for Nuclear Research (CERN)"),
  																										
  												)
  							),
  	'OLSTVRECTEST' => array( "id" => 1201, 
 							     "name" => "OL Stave Reception Test",
 							     "location" => array(
  													"CERN" => array("ID" => 1181, "Name" => "European Organization for Nuclear Research (CERN)"),
  																										
  												)
  							),
 	  );
$actStatusID = array(
				"open" => 450,
				"closed" => 451

		);
		
$actResult = array(
					"IBHICASS" => array(
						        462 	=> array(
														  "ID" => "IBG", 
														  "HIC_CAT" => "Inner-Barrel(Gold)",
														  "Name" => "Inner-Barrel(Gold) Assembled"),
							    463 	=> array(
														  "ID" => "IBS", 
														  "HIC_CAT" => "Inner-Barrel(Standard)",
														  "Name" => "Inner-Barrel(Standard) Assembled"),
							    464 	=> array(
														  "ID" => "IBW", 
														  "HIC_CAT" => "Inner-Barrel(Wood)",
														  "Name" => "Inner-Barrel(Wood) Assembled"),
									),
					"OBHICASS" => array(
								466 	=> array(
														  "ID" => "OBG", 
														  "HIC_CAT" => "Outer-Barrel(Gold)",
														  "Name" => "Outer-Barrel(Gold) Assembled"),
							    467 	=> array(
														  "ID" => "OBS", 
														  "HIC_CAT" => "Outer-Barrel(Silver)",
														  "Name" => "Outer-Barrel(Silver) Assembled"),
							    465 	=> array(
														  "ID" => "OBB", 
														  "HIC_CAT" => "Outer-Barrel(Bronze)",
														  "Name" => "Outer-Barrel(Bronze) Assembled"),
							    468 	=> array(
														  "ID" => "OBW", 
														  "HIC_CAT" => "Outer-Barrel(Wood)",
														  "Name" => "Outer-Barrel(Wood) Assembled"),
									
									) 
					
	
		);
?>
