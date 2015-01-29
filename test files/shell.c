#include <stdio.h>
#include <sysexits.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/types.h>

#define MAX 100
#define MAXARGS 10

void move(char *first, char *second);

int main()
{
	char *args[MAX]; //for each part of the command line including command and args
	char *command; // the actual command
	char cmd[MAX+1]; //temporary storage for the whole command line
	char *name = getenv("USER"); //the user's name
	
	int run = 1; //when set to 0 the quit comman has been executed and execution stops
	
	char *currentDir = getenv("PWD"); //set the current directory
	
	//welcome message
	printf( "\n\n\n\n\n\n\n\n\n\n\n\n\n\n");
	printf( "  \e[0;34m              _______\n");
	printf( "                \\     /\n");
	printf( "                 l   l\n");
	printf( "     __          l   l\e[m______________________________________________\n");
	printf( "  \e[0;34m  1  l_________l   l\e[m                                              \\");
	printf( "  \n");
	printf( "  \e[0;34m  l  l/ / / / /l   l\e[m_______________________________________________\\");
	printf( "  \n");
	printf( "  \e[0;34m  l  l_/_/_/_/_l   l        \e[0;31m  Welcome to Nick's Shell   \e[m           /\n");
	printf( "  \e[0;34m  l__l         l   l\e[m______________________________________________/\n");
	printf( "  \e[0;34m               l   l\n");
	printf( "                 l   l\n");
	printf( "                /_____\\");
	printf( "\n");
	printf( "\n");
	printf( "\n\n\n");
	
	while(run == 1) //run untill quit command is entered
	{
		printf( "\e[0;32m"); //color it green
		printf("%s%s%s%s%s", "[", name, "]",getenv("PWD"), ": "); //print prompt
		printf("\e[m"); //end the green
		
		fgets(cmd, MAX, stdin); //get in the whole line
		
		args[0] = strtok(cmd, " \n"); //get command
		
		command = args[0]; //set the command
		
		if(command != NULL) // make sure they entered something
		{
			if(strcmp(command,"quit") == 0) //handle the quit command
			{
				run = 0;
			}
			else if(strcmp(command,"cd") == 0) //handle the cd command
			{
				currentDir = getenv("PWD");
				
				char *newDir;
				char *enteredDir;
				args[1] = strtok(NULL, " \n");
				enteredDir = args[1];
				
				if(enteredDir == NULL) // no arguments for cd
				{
					newDir = currentDir;
				}
				else if(args[1][0] == '/') //new directory begins with a '/'
				{
					newDir = currentDir;
					strcat(newDir,enteredDir);
				}
				else if(strcmp(enteredDir,"..") != 0) //new directory is just a folder name
				{
				    newDir = strcat(currentDir,"/");
					newDir = strcat(newDir,enteredDir);
				}
				else if(strcmp(enteredDir,"..") == 0) //new directory must go back a directory
				{	
					char *pwd = currentDir;
					char *place;
					place = strrchr(pwd,'/');
					*place = '\0';
					
					newDir = pwd;
				}
				
				printf("%s\n",newDir); //print the new directory
				  
				if(chdir(newDir) != 0) //check if it exists
				{
					char *place;
					place = strrchr(newDir,'/');
					*place = '\0';
				    printf("Directory does not exist\n");
				}
				
				setenv("PWD",newDir,1);
				
				enteredDir = NULL;
				newDir = NULL;
			}
			else // block of code for executing all other commands
			{
				char *temp = strtok(NULL, " \n");
				
				int counter = 1;
				
				while(temp != NULL) // take in all arguments
				{
					args[counter++] = temp;
					temp = strtok(NULL, " \n");
				}
				
				if(fork() == 0) // fork to execute command
				{
					execvp(args[0],args);
					exit(0);
				}
				
				wait(NULL);
			}
		}
		
		int i = 0;
		for(i = 0; i < MAX; i++)
			args[i] = NULL;
			
		command = NULL;
	}
}
