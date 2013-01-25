/*     */ package it.gotoandplay.util.launcher;
/*     */ 
/*     */ import java.io.FileInputStream;
/*     */ import java.io.IOException;
/*     */ import java.lang.reflect.Method;
/*     */ import java.util.Arrays;
import java.util.Properties;
/*     */ 
/*     */ public final class Boot
/*     */ {
/*     */   private static final String version = "1.0.2";
/*     */   private static final String KEY_BOOT_CLASS_NAME = "bootClassName";
/*     */   private static final String KEY_LIB_FOLDERS = "libFolders";
/*     */   private static final String KEY_DEBUG = "debug";
/*  17 */   private static String CFG_FILE_NAME = "boot.properties";
/*  18 */   private static String FOLDER_SEPARATOR = ",";
/*     */   private String[] libFolders;
/*     */   private String bootClassName;
/*     */   private static boolean debug = true;
/*     */   private ClassLoader bootClassLoader;
/*     */   private final IClassLoader jarLoader;
/*     */ 
/*     */   public Boot(String[] args)
/*     */   {
/*  29 */     this.jarLoader = new JarLoader();
			  System.out.println("Boot到底有没有执行?");
/*     */     try
/*     */     {
/*  34 */       loadConfiguration();
/*     */ 
/*  37 */       loadDependencies();
/*     */ 
/*  40 */       startMain(args);
/*     */     }
/*     */     catch (BootException err)
/*     */     {
/*  44 */       System.out.println(err);
/*     */     }
/*     */     catch (IOException err)
/*     */     {
/*  48 */       System.out.println("I/O Error loading the boot configuration file: " + err);
/*     */ 
/*  50 */       if (isDebug())
/*  51 */         err.printStackTrace();
/*     */     }
/*     */     catch (Exception err)
/*     */     {
/*  55 */       System.out.println("Unexpected error at boot time: " + err);
/*     */ 
/*  57 */       if (isDebug())
/*  58 */         err.printStackTrace();
/*     */     }
/*     */   }
/*     */ 
/*     */   public static boolean isDebug()
/*     */   {
/*  65 */     return debug;
/*     */   }
/*     */ 
/*     */   private void loadConfiguration() throws IOException, BootException
/*     */   {
/*  70 */     Properties config = new Properties();
/*  71 */     config.load(new FileInputStream(CFG_FILE_NAME));
/*     */ 
/*  73 */     this.bootClassName = config.getProperty("bootClassName");
/*  74 */     String folders = config.getProperty("libFolders");
/*  75 */     //debug = config.getProperty("debug") != null;
/*     */     debug = true;//TODO:changed by chenjie
/*  77 */     if ((this.bootClassName == null) || (this.bootClassName.length() == 0)) {
/*  78 */       throw new BootException("Boot Main Class was not provided! Booting aborted.");
/*     */     }
/*  80 */     if ((folders == null) || (folders.length() == 0)) {
/*  81 */       throw new BootException("No Library Folders provided! Booting aborted.");
/*     */     }
/*  83 */     if (debug) {
/*  84 */       signature();
/*     */     }
/*     */ 
/*  87 */     this.libFolders = folders.split("\\" + FOLDER_SEPARATOR);
/*     */   }
/*     */ 
/*     */   private void loadDependencies() throws BootException
/*     */   {
			  System.out.println("开始加载lib目录下面的内容..."+Boot.class.getClassLoader().getClass().getName());
/*  92 */     this.bootClassLoader = this.jarLoader.loadClasses(this.libFolders, Boot.class.getClassLoader());
/*     */   }
/*     */ 
/*     */   @SuppressWarnings({ "unchecked", "rawtypes" })
			private void startMain(String[] args)
/*     */     throws BootException
/*     */   {
/*  98 */     Thread.currentThread().setContextClassLoader(this.bootClassLoader);
/*     */     try
/*     */     {
/* 103 */       Class mainClass = this.bootClassLoader.loadClass(this.bootClassName);
/*     */ 
/* 106 */       Method mainMethod = mainClass.getMethod("main", new Class[] { java.lang.String[].class });
/*     */ 
/* 108 */       if (debug) {
/* 109 */         System.out.println("Launching Main with args: " + Arrays.toString(args));
/*     */       }
/*     */ 
/* 112 */       mainMethod.invoke(null, new Object[] { args });
/*     */     }
/*     */     catch (SecurityException e)
/*     */     {
/* 116 */       throw new BootException("Error running main(String[] args) method on Boot Class: " + e);
/*     */     }
/*     */     catch (NoSuchMethodException e)
/*     */     {
/* 120 */       throw new BootException("No main(String[] args) method in Boot Class " + e);
/*     */     }
/*     */     catch (Exception e)
/*     */     {
/* 124 */       if (isDebug()) {
/* 125 */         e.printStackTrace();
/*     */       }
/* 127 */       throw new BootException("Unexpected error: " + e);
/*     */     }
/*     */   }
/*     */ 
/*     */   private void signature()
/*     */   {
/* 135 */     System.out.println("::::::::::::::::::::::::::::::::::::::::::::::::::");
/* 136 */     System.out.println("   AppLauncher - 1.0.2 - (c) 2009 gotoAndply()");
/* 137 */     System.out.println("::::::::::::::::::::::::::::::::::::::::::::::::::");
/*     */   }
/*     */ 
/*     */   public static void main(String[] args)
/*     */   {
/* 143 */     if (args.length > 0) {
/* 144 */       CFG_FILE_NAME = args[0];
/*     */     }
/*     */ 
/* 147 */     if (args.length > 1)
/* 148 */       args = (String[])Arrays.copyOfRange(args, 1, args.length);
/*     */     else {
/* 150 */       args = new String[0];
/*     */     }
/*     */ 
/* 153 */     new Boot(args);
/*     */   }
/*     */ }
