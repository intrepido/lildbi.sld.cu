<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:output method="xml" encoding="UTF-8"/>
	
	<xsl:template match="ListRecords">
	    <xsl:element name="docs">
	       <xsl:call-template name="titulo"/>		
	    </xsl:element>
	</xsl:template>
	
	<xsl:template name="titulo">	 
	  
	    <xsl:for-each select="record/metadata/isis">
	       <xsl:element name="doc">
			  <xsl:for-each select="*">		   
					<xsl:copy-of select="."/>	
			  </xsl:for-each>        
		   </xsl:element>  
        </xsl:for-each> 
        	
    </xsl:template>
	
</xsl:stylesheet>