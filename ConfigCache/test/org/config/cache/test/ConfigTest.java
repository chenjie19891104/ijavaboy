package org.config.cache.test;

import java.util.Iterator;
import java.util.List;
import java.util.Map;

import org.config.cache.ConfigEngine;
import org.config.cache.ConfigType;
import org.config.cache.data.DropConfig;
import org.config.cache.data.GlobalConfig;
import org.config.cache.data.MonsterGroupConfig;
import org.config.cache.data.MonsterRefreshConfig;
import org.junit.Before;
import org.junit.Test;

/**
 * @author chenjie
 * 2012-12-5
 */
public class ConfigTest {


	@Before
	public void setUp() throws Exception {
	}

	@Test
	public void configTest(){
		
		ConfigEngine engine = ConfigEngine.getInstance();
		
		engine.init();
		
		//testList(engine);
		testMap(engine);
	}
	
	private void testList(ConfigEngine engine){
		
		List<MonsterRefreshConfig> list = engine.getConfigList(ConfigType.MONSTER_REFRESH);
		
		System.out.println(list.size());
		
		System.out.println(list.get(0));
	}
	
	private void testMap(ConfigEngine engine){
		
		Map<String, GlobalConfig> map = engine.getConfigMap(ConfigType.GLOBAL_CONFIG);
		
		if(map != null){
			System.out.println(map.size());
			Iterator<String> keySet = map.keySet().iterator();
			while(keySet.hasNext()){
				String key = keySet.next();
				System.out.println(key + " : " + map.get(key).getValue());
			}
		}else {
			System.out.println("map is null");
		}
	}
	
	

//	@Test
//	public void testParser() throws SimpleConfigException{
//		
//		String path = "file:///c:/cache/area";
//		
//		IReader reader = new LineReader();
//		IDecoder<Area> decode = new AreaTextDecoder();
//		
//		IParser<Area> parser = new TextParser<Area>(reader, decode);
//		
//		Map<Integer, Area> result = parser.parse(path);
//		
//		if(result != null && result.size() > 0){
//			
//			Iterator<Integer> keySet = result.keySet().iterator();
//			while(keySet.hasNext()){
//				Area a = result.get(keySet.next());
//				System.out.println(a.toString());
//			}
//		}else {
//			System.out.println("null");
//		}
//	}
	
//	@Test
//	public void testReader() {
//		
//		//String path = "http://192.168.1.6:8088/JsonFile/area";
//		
//		String path = "file:///c:/cache/castle_base";
//		
//		try {
//			
//			//Map<Integer, Area> areaMap = JSONReader.read(path, Area.class);
//			IReader reader = new LineReader();
//			String result = reader.read(path);
//			
//			System.out.println(result);
//			
//		} catch (SimpleConfigException e) {
//			e.printStackTrace();
//		}
//		
//	}

}
