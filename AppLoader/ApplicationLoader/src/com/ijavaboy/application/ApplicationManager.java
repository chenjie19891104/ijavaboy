package com.ijavaboy.application;

import java.io.File;
import java.net.URISyntaxException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

import org.apache.commons.vfs.FileListener;
import org.apache.commons.vfs.FileObject;
import org.apache.commons.vfs.FileSystemException;
import org.apache.commons.vfs.FileSystemManager;
import org.apache.commons.vfs.VFS;
import org.apache.commons.vfs.impl.DefaultFileMonitor;

import com.ijavaboy.config.AppConfig;
import com.ijavaboy.config.AppConfigManager;
import com.ijavaboy.config.GlobalSetting;
import com.ijavaboy.jar.loader.IClassLoader;
import com.ijavaboy.jar.loader.SimpleJarLoader;


/**
 * Manage all the application
 * @author ijavaboy
 * @site <url>http://www.ijavaboy.com</url>
 * 2013-5-10
 */
public class ApplicationManager {

	private static ApplicationManager instance;
	
	private IClassLoader jarLoader;		//the loader to load application jar files
	private AppConfigManager configManager;	
	private FileSystemManager fileManager;
	private DefaultFileMonitor fileMonitor;
	
	private Map<String, IApplication> apps;	//all the applications already loaded
	
	private ApplicationManager(){
	}
	
	public void init(){
		jarLoader = new SimpleJarLoader();
		configManager = new AppConfigManager();
		apps = new HashMap<String, IApplication>();
		
		initAppConfigs();
		
		URL basePath = this.getClass().getClassLoader().getResource("");
		
		loadAllApplications(basePath.getPath());
		
		initMonitorForChange(basePath.getPath());
	}
	
	/**
	 * Load all the app configs to memory
	 */
	public void initAppConfigs(){
		
		try {
			URL path = this.getClass().getClassLoader().getResource(GlobalSetting.APP_CONFIG_NAME);
			configManager.loadAllApplicationConfigs(path.toURI());
		} catch (URISyntaxException e) {
			e.printStackTrace();
		}
	}
	
	/**
	 * Load all the apps specified in the applications.xml file
	 */
	public void loadAllApplications(String basePath){
		
		for(AppConfig config : this.configManager.getConfigs()){
			this.createApplication(basePath, config);
		}
	}
	
	/**
	 * Initial the monitor to listen the change event of the application jar files
	 * Here I used the apache common vfs component to monitor the change event
	 * If you want to learn more about vfs, you can visit:
	 * <url>http://commons.apache.org/proper/commons-vfs/</url>
	 * @param basePath
	 */
	public void initMonitorForChange(String basePath){
		try {
			this.fileManager = VFS.getManager();
			
			File file = new File(basePath + GlobalSetting.JAR_FOLDER);
			FileObject monitoredDir = this.fileManager.resolveFile(file.getAbsolutePath());
			FileListener fileMonitorListener = new JarFileChangeListener();
			this.fileMonitor = new DefaultFileMonitor(fileMonitorListener);
			this.fileMonitor.setRecursive(true);
			this.fileMonitor.addFile(monitoredDir);
			this.fileMonitor.start();
			System.out.println("Now to listen " + monitoredDir.getName().getPath());
			
		} catch (FileSystemException e) {
			e.printStackTrace();
		}
	}
	
	/**
	 * Use a special class loader to load the application specified in the config
	 * @param config
	 * @return
	 */
	public void createApplication(String basePath, AppConfig config){
		String folderName = basePath + GlobalSetting.JAR_FOLDER + config.getName();
		ClassLoader loader = this.jarLoader.createClassLoader(ApplicationManager.class.getClassLoader(), folderName);
		
		try {
			Class<?> appClass = loader.loadClass(config.getFile());
			
			IApplication app = (IApplication)appClass.newInstance();
			
			app.init();
			
			this.apps.put(config.getName(), app);
			
		} catch (ClassNotFoundException e) {
			e.printStackTrace();
		} catch (InstantiationException e) {
			e.printStackTrace();
		} catch (IllegalAccessException e) {
			e.printStackTrace();
		}
	}
	
	/**
	 * Reload the specified application, first to undeploy it , and then create it.
	 * @param name
	 */
	public void reloadApplication(String name){
		IApplication oldApp = this.apps.remove(name);
		
		if(oldApp == null){
			return;
		}
		
		oldApp.destory();	//call the destroy method in the user's application
		
		AppConfig config = this.configManager.getConfig(name);
		if(config == null){
			return;
		}
		
		createApplication(getBasePath(), config);
	}
	
	public static ApplicationManager getInstance(){
		if(instance == null){
			instance = new ApplicationManager();
		}
		return instance;
	}
	
	/**
	 * Get the application by name
	 * @param name
	 * @return
	 */
	public IApplication getApplication(String name){
		if(this.apps.containsKey(name)){
			return this.apps.get(name);
		}
		return null;
	}
	
	public String getBasePath(){
		return this.getClass().getClassLoader().getResource("").getPath();
	}
}
