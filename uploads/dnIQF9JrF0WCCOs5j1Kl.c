#include <stdio.h>
char* StrToUpper(char* str)
{
    char* p;
    for (p = str ;
    *p ;
    ++p) *p = toupper(*p);
    return str;
}
//Long line..............................................................................
main (int argc, char *argv[])
{
    printf("%s", StrToUpper(argv[1]));
}
