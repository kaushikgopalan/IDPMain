/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package proj1;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.IOException;
import java.io.PrintWriter;
import static java.lang.System.exit;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 *
 * @author kaushik
 */
public class TEST {
    public static void main(String argsp[]){
   
        String temp="";
    
    List<String> names=new ArrayList<String>();
    int counter=0;
    int i=0;
    while(true){
        String cur=temp.substring(temp.indexOf("title=\""),temp.indexOf(temp.indexOf("\""), temp.indexOf("title=\"")));
        System.out.println(cur);
        temp=temp.substring(temp.indexOf(cur));
        i++;
        if(i==100)
            break;
    }
    
    }// end of main()
  
 }
