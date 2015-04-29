#include <stdio.h>
char* StrToUpper(char* str)
{
    char* p;
    for (p = str; *p; ++p){*p = toupper(*p);}
    return str;
}


/*
	11
	2
	3
	4
	5
	6
	7
	8
	9
*/





main (int argc, char *argv[])
{
    printf("%s", StrToUpper(argv[1]));
}

