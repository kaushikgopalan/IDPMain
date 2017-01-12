/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package proj1;
import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.util.HashMap;
import java.util.Hashtable;
import java.util.Iterator;
import java.util.Map;

/**
 *
 * @author kaushik
 */
public class TestCsv {
    public static void main(String args[]){
        String csvFile = "H:\\\\Pakx\\delivery.csv";
	BufferedReader br = null;
	String line = "";
	String cvsSplitBy = ",";
        Map<String, Integer> days =new HashMap<String, Integer>();
        Map<String, String> deliveries= new HashMap<String,String>();
        
	try {

		br = new BufferedReader(new FileReader(csvFile));
		while ((line = br.readLine()) != null) {

		        // use comma as separator
			String[] lineData = line.split(cvsSplitBy);

			//System.out.println("Day:" + lineData[0]+" and "+lineData[1]+" and "+lineData[2]);
                        String tempDay=lineData[0].trim()+lineData[1].trim();
                        //System.out.println("tempday: "+tempDay);
                        if(!days.containsKey(tempDay)){
                            days.put(tempDay, 1);
                        }
                        else days.put(tempDay,(days.get(tempDay))+1);
                        if(deliveries.containsKey(lineData[2])){
                            
                        }
                        else deliveries.put(lineData[2],lineData[0].trim()+", "+lineData[1].trim());
                        System.out.println(deliveries.get(lineData[2])+" deliveries hash "+lineData[2]);
                        
                        //System.out.println(tempDay+" tempday: "+days.get(tempDay));
		}
                System.out.println("days value: "+ days.size());
                Iterator it = days.entrySet().iterator();
                int temp=0;
//                while (it.hasNext()) {
//                    Map.Entry pair = (Map.Entry)it.next();
//                    System.out.println(pair.getKey() + " = " + pair.getValue());
//                    temp+= Integer.parseInt(pair.getValue()+"");
//                    //it.remove(); // avoids a ConcurrentModificationException
//                }
//                
                Iterator it2 = deliveries.entrySet().iterator();
                int temp2=0;
                System.out.println("deliveries: ");
                while (it.hasNext()) {
                    Map.Entry pair = (Map.Entry)it.next();
                    System.out.println(pair.getKey() + " = " + pair.getValue());
                    temp+= Integer.parseInt(pair.getValue()+"");
                    //it.remove(); // avoids a ConcurrentModificationException
                }
                 System.out.println("days value: "+ days.size()+"deliveries size: "+deliveries.size());
                 System.out.println(temp);

	}catch(Exception e){
            e.printStackTrace();
            System.out.println("Exception e: "+e);
        }
    }
}
