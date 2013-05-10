package com.ijavaboy.application;

import org.apache.commons.vfs.FileChangeEvent;
import org.apache.commons.vfs.FileListener;

/**
 * listen the change event of the application jar files
 * @author ijavaboy
 * @site <url>http://www.ijavaboy.com</url>
 * 2013-5-10
 */
public class JarFileChangeListener implements FileListener {
	
	public JarFileChangeListener(){
	}

	@Override
	public void fileChanged(FileChangeEvent event) throws Exception {

		String ext = event.getFile().getName().getExtension();
		if(!"jar".equalsIgnoreCase(ext)){
			return;
		}
		
		String name = event.getFile().getName().getParent().getBaseName();
		
		ApplicationManager.getInstance().reloadApplication(name);
		
	}

	@Override
	public void fileCreated(FileChangeEvent arg0) throws Exception {
	}

	@Override
	public void fileDeleted(FileChangeEvent arg0) throws Exception {
	}

}
