package it.gotoandplay.util.launcher;

public abstract interface IClassLoader
{
  public abstract ClassLoader loadClasses(String[] paramArrayOfString, ClassLoader paramClassLoader)
    throws BootException;
}
