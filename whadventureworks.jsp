<%@ page session="true" contentType="text/html; charset=ISO-8859-1" %>
<%@ taglib uri="http://www.tonbeller.com/jpivot" prefix="jp" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jstl/core" %>


<jp:mondrianQuery id="query01" jdbcDriver="com.mysql.jdbc.Driver" 
jdbcUrl="jdbc:mysql://localhost/db_adventure_olap?user=root&password=" catalogUri="/WEB-INF/queries/whadventureworks.xml">

select {[Measures].[Amount],[Measures].[Quantity]} ON COLUMNS,
  {([Product].[All Products],[Time].[All Times],[Customer])} ON ROWS
from [penjualan]


</jp:mondrianQuery>





<c:set var="title01" scope="session">Adventure Works Mondrian OLAP Sales</c:set>
