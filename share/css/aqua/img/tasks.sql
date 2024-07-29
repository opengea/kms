-- MySQL dump 10.11
--
-- Host: localhost    Database: olgamiracle
-- ------------------------------------------------------
-- Server version	5.0.90-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `kms_tasks`
--

DROP TABLE IF EXISTS `kms_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_tasks` (
  `id` int(11) NOT NULL auto_increment,
  `status` varchar(100) NOT NULL default '',
  `external_url` varchar(100) NOT NULL default '',
  `priority` varchar(100) NOT NULL default '',
  `order` int(11) NOT NULL default '0',
  `dr_folder` varchar(100) NOT NULL default '',
  `related` varchar(100) NOT NULL default '',
  `description` varchar(100) NOT NULL default '',
  `notes` text NOT NULL,
  `assigned` varchar(100) NOT NULL default '',
  `creation_date` date NOT NULL default '0000-00-00',
  `file` varchar(100) NOT NULL default '',
  `satisfaction` varchar(100) NOT NULL default '',
  `final_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_tasks`
--

LOCK TABLES `kms_tasks` WRITE;
/*!40000 ALTER TABLE `kms_tasks` DISABLE KEYS */;
INSERT INTO `kms_tasks` VALUES (1,'pendent','','normal',0,'1','','Passar i arxivar la llista de contactes dels que van venir al concert','\r\n','Karl','2008-02-16','llibreta_olga.ldif','no avaluat','0000-00-00'),(2,'finalitzat','','normal',0,'1','','Transport partitura Senyor Ribé.','','Karl','2008-02-08','','no avaluat','2008-02-17'),(3,'pendent','','normal',0,'1','','DISC MOZART','DISC MOZART\r\n\r\n1- escriure/trucar Pep Sala. Dia 7/2 enviat mail\r\n\r\n        -saber la seva opinió sobre l\'enregistrament\r\n        -pressupost edició 500 còpies\r\n        -dates de quan es pot dur a terme l\'edició \r\n\r\n2- disseny\r\n\r\n    2-hem de pensar com/qui farà el disseny de la caràtula. El Jordi no\r\n    disposa de temps. Per tant, he pensat que tu i jo farem un esborrany, ja\r\n    tinc algunes idees, i el Jordi ens l\'arreglarà. Jo voldria dedicar les\r\n    quatre hores de la setmana que ve al disseny.\r\n\r\nEntrevista Joan Vives el 7/2\r\n\r\n    S\'haurà de transcriure entrevista i seleccionar-ne fragments per a\r\n    l\'inbterior caràtula Cd.\r\n','Karl','2008-02-08','','no avaluat','0000-00-00'),(4,'pendent','','normal',0,'1','','Concerts Menorca - recullir \"saldo\"','Concerts Menorca\r\n10 de febrer, Alaior:  Espai Cultural Rotger a les 19.30 h\r\n11 de febrer, Ciutadella: Sala d\'Actes del Centre Social Sa Nostra a les 20.45 h.\r\n\r\n    1-Mertxe Orfila- directora del Gloria i Magnificat de Vivaldi que vaig cantar com a solista a Menorca el 2004.  mmertxe@telefonica.net\r\n    És la directora dels Cors de l\'òpera de Maó i molt considerada a l\'illa.\r\n    2-Al mossèn de l\'orgue (jo ja m\'entenc).... Párroco de San Martín fcarvid67@gmail.com\r\n    3-Lluís Sintes- que ho enviï als seus contactes lluis@lluissintes.com\r\n    4-Família de la Natàlia (dona del meu germà gran), que són d\'Alaior i vindrien segur si se n\'assabenten.... FET\r\n    5-Fèlix - concertino de l\'orquestra barroca de Maó, violinista de nivell internacional i bon amic i col.lega meu de quan vivia a Barcelona (fa temps que viu a Menorca... ves a saber on tinc les seves dades... i a sobre no me\'n recordo del cognom....) 676356466\r\n    6-Trucar Cris (amiga del Karl) 655306686 971355974','Karl','2008-02-16','','no avaluat','0000-00-00'),(5,'finalitzat','','critica',0,'1','','Transcripció Entrevista Joan Vives','    S\'haurà de transcriure entrevista i seleccionar-ne fragments per a\r\n    l\'inbterior caràtula Cd.','Karl','2008-02-08','','no avaluat','2008-02-17'),(6,'pendent','','normal',0,'1','','Viatges a Berga','VIATGES BERGA\r\n\r\n    3-Necessitaria que busquessis persona (coneguda o professional) ja sigui\r\n    a través de contactes o per internet, per venir-me a buscar a Berga els\r\n    dimecres a la nit.\r\n    Es tractaria de sortir de Bcn a les 20.40 per arribar a les 22.00,\r\n    recollir-me i s\'arribaria a Bcn a les 22.20.\r\n    Són tres hores curtes de feina, jo posaria cotxe i benzina, i pagaria\r\n    preu hora assequible tenint en compte que seria una feina setmanal.\r\n    Avui agafaré un taxi que em costa 100, 00 euros, per tant si no trobo\r\n    altra solució, hauré de deixar la feina.\r\n    Altra possibilitat: buscar per internet, fórums o el que sigui, algú que\r\n    viatgi de Berga a Barcelona els dimecres a les deu de la nit, i proposar\r\n    compartir despeses.','Karl','2008-02-08','','no avaluat','0000-00-00'),(7,'en_proces','','normal',0,'1','','Gravadora digital exp. 10047623','http://www.musik-produktiv.es/zoom-h2.aspx','Olga','2008-02-08','','no avaluat','0000-00-00'),(8,'pendent','','normal',0,'1','','Disc Morera','DISC MORERA\r\n\r\nPep Sala\r\n-----------\r\nDates 1 al 10 de juliol\r\n\r\nAclarir amb el Pep si el \"catxé\" de 3000 euros per enregistrar el cd català inclou l\'edició i còpies. \r\nJordi Tomàs CD\'s\r\nQuè ens pot aportar la Francesca Galofré i si es comptaria amb la subvenció de Dinsic, si cal fer partitures o només disc\r\n - llibret\r\n','Karl','2008-02-08','','no avaluat','0000-00-00'),(55,'pendent','','normal',0,'1','','Disseny Cd Mozart','','','2008-05-10','Disseny Cd.doc','no avaluat','0000-00-00'),(56,'pendent','','normal',0,'1','','Entrevista Olga Mozart','','','2008-05-10','Olga_Mozart_3 doc.doc','no avaluat','0000-00-00'),(9,'en_proces','','normal',4,'1','','Dietes Fusic','Dietes FUSIC\r\n\r\n    7-Reclamar a Fusic un import de dietes que em deuen de concert passat\r\n    juliol.\r\n    Nom del contacte Pau Aguilar.\r\n\r\nImport: 76,88 € en concepte de les dietes del concert de Les Trobadories d\'en Guillem de Berguedà el 6 de juliol de 2007.\r\n\r\nFUSIC\r\nC/ Consell de Cent 347,s/àtic\r\n08007 Barcelona\r\nEspanya\r\n\r\nTelèfon: 932-157-411\r\nFax: 932-157-932\r\n\r\ne-mail:info@fusic.org','Karl','2008-02-08','','no avaluat','0000-00-00'),(10,'pendent','','normal',3,'1','','Factura CAOC','6-Reclamar clamar factura emesa el 24/1 a Enric Garriga (CAOC) en\r\nconcepte de la meva participació a l\'acte del 30 aniversari del CAOC el\r\n21 de gener passat. La factura està emesa des de Musica Vivit i ve\r\nindicat un número de compte, és de 450 + 7% IVA (total 481,50). Enric\r\nGarriga caoc@caoc.cat. Podem utilitzar l\'adreça info@musicavivit.com per\r\naquest tipus de gestions. Reclamada per mail el 7/2 al Sr. Garriga.\r\nHotel d\'Entitats. Providència, 42\r\n08024 BARCELONA\r\n(Països Catalans)\r\nTelf. 93.284.36.34\r\nFax 93.213.76.48\r\ncaoc@caoc.cat\r\nPresident: Enric Garriga Trullols\r\n\r\n','Karl','2008-02-08','factura-30aniversariCAOC.pdf','no avaluat','0000-00-00'),(50,'pendent','','normal',0,'1','','Tema conte - possible presentació Ateneu barcelonès','','','2008-03-03','','no avaluat','0000-00-00'),(51,'pendent','','normal',0,'1','','Digitalitzar cd Musica Vivit','','Karl','2008-03-04','','no avaluat','0000-00-00'),(52,'pendent','','normal',0,'1','','Suggeriments web','\"Mostres\" per \"Media\" o \"Audio/Video\"\r\nExplicació a llista de correu\r\nActualitzar fotos\r\n','','2008-03-04','','no avaluat','0000-00-00'),(54,'pendent','','normal',-1,'1','CONTE AGUSTI I MARTINA','Conte: trucada amalia','1. Dates reals i concretes\r\ncalendari d\'entrega...\r\n\r\n2. Il.lustracio text (cartes agusti) textura fulles d\'alzina...\r\n\r\n3. tamany de pagina i marges...\r\n\r\n4. coloring book\r\n\r\n','olga dani','2008-03-16','','no avaluat','0000-00-00'),(53,'pendent','','normal',0,'1','','Mertxe Orfila- tema Amics de l\'Òpera de Maó','Contactar amb Mertxe pel tema de l\'òpera de Maó.','','2008-03-05','','no avaluat','0000-00-00'),(49,'pendent','','alta',5,'1','','Enviar crítica Menorca a alguns contactes','Estaria bé enviar la crítica de Menorca a:\r\n\r\n\r\n-Mossèn Francesc- així es respon el seu mail\r\n-Marijó: excusa per contactar novament\r\n-Giuseppe di Matteis\r\n-Celsa Tamayo\r\n-papa\r\n-Romà Escalas - aprofito per enviar adreça de correu per societat musicologia... dir-li País Basc...','','2008-02-27','','no avaluat','0000-00-00'),(48,'pendent','','critica',0,'1','','Stella Splendens per UCE','','','2008-02-25','','no avaluat','0000-00-00'),(47,'pendent','','alta',2,'1','','Programa Olga- Ticià ODA','Enviar programa Menorca a l\'ODA','','2008-02-24','concerts menorca 08.doc','no avaluat','0000-00-00'),(46,'finalitzat','','critica',1,'1','','Enviar a Ticià Riera llista d\'assistents al concert a la Sala Vivit','Ticià Riera\r\n\r\nticia.riera@gmail.com','','2008-02-24','','no avaluat','0000-00-00'),(45,'finalitzat','','normal',0,'1','','actualitzar web: posar dates de concerts a agenda i crítica Menorca','s\'han afegit les dates:\r\n23 de febrer-Cançons de Falla\r\n7 de març -Stabat Mater\r\n\r\nS\'ha afegit pàrraf de crítica del diari de Menorca del 12 de febrer de 2008','','2008-02-21','','no avaluat','0000-00-00'),(44,'pendent','','normal',0,'1','','ordenar partitures!!!!!!!','','?????','2008-02-21','','no avaluat','0000-00-00'),(43,'pendent','','normal',0,'1','','Afegir contactes Menorca de cara concert orgue i flauta','mossèn Francesc - església de Es Mercadal\r\n\r\nPere Gomila - Alaior\r\n','Olga','2008-02-21','','no avaluat','0000-00-00'),(42,'pendent','','normal',0,'1','','indagar òpera València- Palau de les Arts','Investigar:\r\nsra ... Smidt\r\n\r\nLorin Maazel\r\n\r\nagent: marit Ana Luisa Chova','Karl','2008-02-21','','no avaluat','0000-00-00');
/*!40000 ALTER TABLE `kms_tasks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-12-09 12:31:26
