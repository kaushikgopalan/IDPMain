/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package proj1;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.FileReader;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.htmlunit.HtmlUnitDriver;

import static org.openqa.selenium.remote.CapabilityType.SUPPORTS_FINDING_BY_CSS;

import java.io.IOException;
import java.io.PrintWriter;
import static java.lang.System.exit;
import java.net.URISyntaxException;
import java.net.URL;
import java.util.ArrayList;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.openqa.selenium.Capabilities;
import org.openqa.selenium.Platform;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.firefox.FirefoxProfile;
import org.testng.xml.XMLParser;

/**
 *
 * @author kaushik Testing selenium for IDP
 */
public class TestSelenium {

    public static void main(String[] args) throws Exception {

        
        File testFile= new File(TestSelenium.class.getProtectionDomain().getCodeSource().getLocation().toURI().getPath());
        
        //URL filePath = TestSelenium.class.getResource("public/companyList.txt");
        
        String folderPath;
        //URL jarLocation = XMLParser.class.getProtectionDomain().getCodeSource().getLocation();
        //String fileString=filePath.toURI().toString();
        System.out.println("File Path from Stackoverflow code:"+testFile.getAbsolutePath() );
        folderPath= testFile.getAbsolutePath();
        //if(folderPath.contains("\\"))
        folderPath= folderPath.substring(0,folderPath.lastIndexOf(File.separator));
        System.out.println("folderPath= "+folderPath);
        folderPath.replace('\\', '/');
        String companyList= folderPath+"/editableFiles/company list.txt";
        folderPath+="/public/companyPages";
        
                
        System.out.println("after editable files: "+ folderPath);
        System.out.println(" folder path: " + folderPath);
            //testFile=new File(filePath.toURI());
//            PrintWriter fos2= new PrintWriter(testFile, "UTF-8");

            //PrintWriter fos2=new PrintWriter(testFilePath+"something.txt" );//filePath.toExternalForm()+"companyList2.txt","UTF-8");
//            fos2.write("something written here");
//            fos2.close();
//            PrintWriter fos=new PrintWriter(companyFileName+"/test.txt","UTF-8");
//            fos.write("test write.test write");
//            fos.close();
     
        BufferedReader br;
        FirefoxProfile profile = new FirefoxProfile();
        profile.setPreference("javascript.enabled", true);
        WebDriver driver = new FirefoxDriver(profile);
        //System.setProperty("webdriver.chrome.driver", "H:\\Plugins, Templates, CSS ETC\\chromedriver_win32\\chromedriver.exe");
        //driver = new ChromeDriver();
        try {
            testFile = new File(companyList);
            br = new BufferedReader(new FileReader(testFile));
            //String companyNames;
            ArrayList<String> companyNames = new ArrayList<>();
            String currentLine="";
            while ((currentLine = br.readLine()) != null) {
                System.out.println(currentLine);
                companyNames.add(currentLine);

            }// end  while
            if (companyNames.size() < 1) {
                // need to send some error code here.. printed somewhere saying that the file was empty
                System.out.println("File was empty. Exiting.");
                return;
            }

            for (int i = 0; i < companyNames.size(); i++) {
                    // addin the try inside the for.. so for each company it will try and in case it fails
                // it will continue with the other companies.
                try {

                    //Capabilities capabilities = new Capabilities();
                    //driver.close();
                    //driver.quit();
                    driver = new FirefoxDriver(profile);
                    Thread.sleep(2000);
                    //driver.
                    // And now use this to visit Google
                    //driver.manage().ti
                    driver.get("http://www.glassdoor.com/index.htm");
                    System.out.println("Loaded glassdoor.com once.");
                    Thread.sleep(10000);
                    driver.get("http://www.glassdoor.com/index.html");
                    System.out.println("Loaded Glassdoor twice");
                    
                    Thread.sleep(15000);
                    
                    try{
                        
                        driver.findElement(By.xpath("/html/body/div[2]/div/div[1]/div/div[2]/div/span")).click();
                        Thread.sleep(4000);
                        System.out.println("clicked on stay on glassdoor US here.");
                    }
                    catch(Exception e){
                        System.out.println("Exception was:"+e);
                        System.out.println(" click on stay on us glassdoor not found here.");
                    }
                    
                    
                    WebElement element = driver.findElement(By.xpath("//*[@id=\"SrchHero\"]/div/div/div/div/div/form/ul/li[2]"));
                    Thread.sleep(4000);
                    System.out.println("here now. next elemnt to select companies");
                    // Enter something to search for
                    
                    element.click();
                    element = driver.findElement(By.xpath("//*[@id=\"SrchHero\"]/div/div/div/div/div/form/div[1]/div[1]/input"));
                    System.out.println("Entering the following text: " + companyNames.get(i));
                    element.sendKeys(companyNames.get(i) + "");
                    System.out.println("after the search for companies and entered.");
                    driver.findElement(By.xpath("//*[@id=\"SrchHero\"]/div/div/div/div/div/form/div[1]/div[4]/button")).click();
                    System.out.println("after clcking for the element.");
                    String pageSrc;
                    // the if is for those companies for which you directly get the
                    // company instead of going to the page which shows several companies.
                    if(!driver.getCurrentUrl().contains("/Overview/")){
                        driver.findElement(By.xpath("//*[@id=\"MainCol\"]/div/div[5]/div[2]/div[2]/div[1]/a")).click();
                        System.out.println("after the other element search");
                        
                    }
                    
                    pageSrc= driver.getPageSource();
                    // code to print page source..
                    //System.out.println("Page Source:");
                    //System.out.println(driver.getPageSource());
                    String companyFileName = folderPath + "/" + companyNames.get(i) + ".htm";
                    PrintWriter fos = new PrintWriter(companyFileName, "UTF-8");

                    //System.out.println()
                    fos.print(pageSrc);
                    fos.close();

                    // Now submit the form. WebDriver will find the form for us from the element
                    //element.submit();
                    // Check the title of the page
                    System.out.println("Page title is: " + driver.getTitle());

                    driver.close();
                    Runtime.getRuntime().exec("taskkill /F /IM plugin-container.exe");
                    Thread.sleep(200);

                    driver.quit();

                } catch (Exception e) {
                       System.out.println("Failed for the company: " +companyNames.get(i));
                       if(driver!=null)
                        driver.quit();
                }
            }

            // shell_exec("java -jar your_JAR.jar arg1 arg2");
        } catch (Exception e) {
            System.out.println("Exception e: " + e);
            e.getStackTrace();

        }
    }
}
