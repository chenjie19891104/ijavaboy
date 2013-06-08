package org.export.simple;

import java.io.IOException;

/**
 * @author chenjie
 * 2012-12-7
 */
public class MainTest {

	public static void main(String[] args) throws IOException {

		String path = "c:\\cache\\castle_base.xls";
		int type = SimpleExporter.TYPE_TEXT;
		
		SimpleExporter.exportFile(path, type);
		
		
	}

}
