#include "CuTest.h"
#include "strToUpper.c"
    
    /*char* StrToUpper(char* str) {
        char* p;
        for (p = str ; *p ; ++p) *p = toupper(*p);
        return str;
    }*/
    
    void TestStrToUpper(CuTest *tc) {
        char* input = strdup("hello world");
        char* actual = StrToUpper(input);
        char* expected = "HELLO WORLD";
        CuAssertStrEquals(tc, expected, actual);
    }
	
	void TestStrToUpper_EmptyString (CuTest *tc) {
        char* input = strdup("");
        char* actual = StrToUpper(input);
        char* expected = "NULL";
        CuAssertStrEquals(tc, expected, actual);
    }
	
	void TestStrToUpper_UpperCase(CuTest *tc) {
        char* input = strdup("HELLO world");
        char* actual = StrToUpper(input);
        char* expected = "HELLO WORLD";
        CuAssertStrEquals(tc, expected, actual);
    }
   
    CuSuite* StrUtilGetSuite() {
        CuSuite* suite = CuSuiteNew();
        SUITE_ADD_TEST(suite, TestStrToUpper);
		SUITE_ADD_TEST(suite, TestStrToUpper_EmptyString);
		SUITE_ADD_TEST(suite, TestStrToUpper_UpperCase);
        return suite;
    }
