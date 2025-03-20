export interface Writing {
  id: string;
  title: string;
  summary: string;
  date: string;
  content?: string;
  coverImage?: string;
}

export interface Profile {
  name: string;
  bio: string;
  image?: string;
  socialLinks?: {
    twitter?: string;
    instagram?: string;
    email?: string;
  };
}

export interface Announcement {
  id: string;
  content: string;
  date: string;
}