<%@ page session="true" contentType="text/html; charset=ISO-8859-1" %>
<%@ taglib uri="http://www.tonbeller.com/jpivot" prefix="jp" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jstl/core" %>


<jp:mondrianQuery id="query01" jdbcDriver="com.mysql.jdbc.Driver" 
jdbcUrl="jdbc:mysql://localhost/db_adventure_olap?user=root&password=" catalogUri="/WEB-INF/queries/whadventureworksshipment.xml">

select {[Measures].[Total Due],[Measures].[Total Freight]} ON COLUMNS,
  {([Ship Method].[All Ship Method],[Ship To].[All State Province],[Time].[All Times],[Customer])} ON ROWS
from [pengiriman]


</jp:mondrianQuery>





<c:set var="title01" scope="session">Adventure Works Mondrian OLAP Shipment</c:set>
