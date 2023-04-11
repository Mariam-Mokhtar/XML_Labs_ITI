<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <html>
      <head>
        <title>Employees List</title>
      </head>
      <body>
        <h1 align="center">Employee List</h1>
        <table align="center">
          <tr align="center" style="background:rgb( 39, 174, 96 );color:black;">
            <th rowspan="2">ISBN</th>
            <th rowspan="2">Name</th>
            <th rowspan="2">Email</th>
            <th rowspan="2">Phone</th>
            <th colspan="5">Address</th>
          </tr>
          <tr align="center" style="background:rgb( 39, 174, 96 );color:black;">
			<th>Country</th>
			<th>City</th>
			<th>Region</th>
			<th>Street</th>
			<th>Buliding Number</th>
		  </tr>
          <xsl:for-each select="employees/employee">
            <tr align="center">
              <td><xsl:value-of select="@isbn" /></td>
              <td><xsl:value-of select="name" /></td>
              <td><xsl:value-of select="email" /></td>
              <td><xsl:value-of select="phones/phone" /></td>
              <td><xsl:value-of select="addresses/address/Country"/></td>
			  <td><xsl:value-of select="addresses/address/City"/></td>
			  <td><xsl:value-of select="addresses/address/Region"/></td>
			  <td><xsl:value-of select="addresses/address/Street"/></td>
			  <td><xsl:value-of select="addresses/address/BuildingNumber"/></td>
            </tr>
          </xsl:for-each>
        </table>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>