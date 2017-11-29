<?php
// output headers so that the file is downloaded rather than displayed
header("Content-type: text/csv");
header("Content-disposition: attachment; filename = results.csv");
readfile("results.csv");
