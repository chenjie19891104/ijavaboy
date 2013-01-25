package demo.cluster.utils;

public class Logger {
	
	public static final boolean DEBUG = true;
	
	public static void info(String info){
		if(DEBUG){
			System.out.println("ekarma info::"+info);
		}
	}
	
	public static void warn(String info){
		if(DEBUG){
			System.out.println("ekarma warn**" + info);
		}
	}
	
	public static void err(String info){
		if(DEBUG){
			System.out.println("ekarma err->"+info);
		}
	}
	
	public static void reciever(String info){
		if(DEBUG){
			System.out.println("recieve cluster info::"+info);
		}
	}

}
