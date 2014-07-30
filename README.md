LILDBI-WEB
==========

    Author: Fidel Santana Morell (fsantana@infomed.sld.cu)       
    version: 1.8

	
    
Technologies Used
=================

- CakePHP (Framework de PHP)
- CouchDB (Servidor Base de Datos NoSQL)
- Twitter Boostrap (Framework de maquetación)
- JQuery (Librería JavaScript)
- Node JS (Servidor JavaScript)
- Apache Solr (Motor de búsqueda)


    
Install and Setup in Windows
============================

Los ficheros de configuración se encuentran en https://github.com/intrepido/lildbi.sld.cu-install-config.git 

- Maquina Virtual de Java 6 o superior (https://www.java.com)

	- Instalarla.

- XAMPP 1.7.7 o superior (http://www.apachefriends.org/es/xampp.html) 

	- Instalarlo.
	
	- Copiar el proyecto "lildbi.sld.cu", en la carpeta <i>(C:\xampp\htdocs)</i>.
	
    - Crear en MySQL una BD llamada "lildbi".
	
    - Importar desde la BD creada, el archivo <b>lildbi.sld.cu-install-config-master/XAMPP/lildbi.sql</b>, el cual contiene todas las tablas.
	
    - Editar el fichero <i>(C:\xampp\php\php.ini)</i> y poner la configuracion que contiene el fichero <b>lildbi.sld.cu-install-config-master/XAMPP/php.ini</b>, el cual permite la activación de las extensiones "curl", "xsl", "openssl" y "php_solr".
	
    - Editar el fichero <i>(C:\xampp\apache\conf\extra\httpd-vhosts.conf)</i> y poner la configuración que contiene el fichero <b>lildbi.sld.cu-install-config-master/XAMPP/httpd-vhosts.conf</b>, el cual permite crear un virtual host del sitio.
	
	- Editar el fichero <i>(C:\Windows\System32\Drivers\etc\host)</i> y poner la configuración que contiene el fichero <b>lildbi.sld.cu-install-config-master/XAMPP/host</b>, el cual pone disponible localmente al sitio virtual. Se deben tener permisos de administración para poder editar este fichero. 
	
    - Reiniciar el servicio de Apache en el "XAMPP Control Panel" para que se reflejen los cambios.

- CouchDB 1.2.0 o superior (http://couchdb.apache.org/)

    - Instalarlo y acceder a traves de este link (http://localhost:5984/_utils).
	
    - Crear una BD y nombrarla "documents".
	
- NodeJS 0.10.26 o superior (http://nodejs.org/)

    - Instalarlo.	
	
    - Copiar la carpeta <b>lildbi.sld.cu-install-config-master/NodeJS/node_server</b>, en la carpeta <i>(C:\xampp\htdocs)</i>.
	
    - Copiar el fichero <b>lildbi.sld.cu-install-config-master/NodeJS/start-node.bat</b> en el lugar que se desee, este fichero se debe ejecutar antes de correr el proyecto ya que es el que arranca el servidor de NodeJS).
		
- Apache Tomcat 7 o superior (http://tomcat.apache.org/)

	 - Instalarlo.
	 
	 - Editar el fichero <i>(C:\Program Files (x86)\Apache Software Foundation\Tomcat 7.0\conf\server.xml)</i> para que el Tomcat sea accesible desde el puerto 8983. Para ello sustituir la linea que contenga la configuración de la conexión del puerto 8080, por la siguiente.
	 
		<i><Connector port="8983" address="127.0.0.1"  protocol="HTTP/1.1" connectionTimeout="20000" URIEncoding="UTF-8" redirectPort="8443"/></i>
	 
	 - Copiar en <i>(C:\Program Files (x86)\Apache Software Foundation\Tomcat 7.0\webapps)</i> el fichero <b>lildbi.sld.cu-install-config-master/Tomcat/solr.war</b>
	 
	 - Copiar para <i>(C:\Program Files (x86)\Apache Software Foundation\Tomcat 7.0\conf\Catalina\localhost)</i> el fichero <b>lildbi.sld.cu-install-config-master/Tomcat/solr.xml</b> para vincular el Tomcat con la distribución binaria de solr y especificar el camino al fichero solr.war. De no existir las carpetas <i>Catalina</i> y <i>localhost</i> entonces crearlas.
	 
	 - Crear la variables de sesión <i>CATALINA_HOME</i> con valor <i>C:\Program Files (x86)\Apache Software Foundation\Tomcat 7.0</i>.
	 
	 - Copiar la carpeta <b>lildbi.sld.cu-install-config-master/Tomcat/solr</b> para la raiz de <i>C:/</i>. Esta carpeta contiene la distribución binaria de Solr con todas sus configuraciones.
	 
	 - Agregar la extención <b>lildbi.sld.cu-install-config-master/Tomcat/php_solr.dll</b> al directorio del xampp <i>(C:\xampp\php\ext)</i>
	 
	 - Iniciar el tomcat y probar que está funcionando por el puerto 8983. Acceder a (http://localhost:8983/solr) para ver la interfaz de administración del Solr.
   



