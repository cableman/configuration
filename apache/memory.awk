#/usr/bin/env awk
{
    count[NR] = $0;
    if (min == "") {
        min = max = $0
    };
    if ($0 > max) {
        max = $0
    };
    if ($0 < min) {
        min = $0
    };
}
END {
    print "Processes: ", length(count);
    if (NR % 2) {
        print "Median: ", count[(NR + 1) / 2], "\r";
    } else {
        print "Median: ", (count[(NR / 2)] + count[(NR / 2) + 1]) / 2.0, "\r";
    }
    print "Max:", max, "\r";
    print "Min:", min;
}

