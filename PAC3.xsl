<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <!-- TODO customize transformation rules 
         syntax recommendation http://www.w3.org/TR/xslt 
    -->
    <xsl:template match="/">
        <table border="0" cellspacing="5" cellpadding="5" width="100%" style="padding: 5px; margin: 5px; border-color:#000000; border-width:1; border-style:solid ">
            <xsl:for-each select="photos/photo">
                <tr style="background-color:DarkSeaGreen;">
                    <td width="200px">
                        <xsl:variable name="link" select="@url_m" />
                        <img src="{$link}" width="200px"/>
                    </td>
                    <td style="vertical-align:bottom;text-align:left;">
                        Autor: 
                        <xsl:value-of select="@ownername" />
                        <br/>
                            Etiquetes: 
                        <xsl:value-of select="@tags" />
                    </td>
                </tr>
            </xsl:for-each>
        </table>
    </xsl:template>

</xsl:stylesheet>
