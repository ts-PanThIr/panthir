export interface IMainMenuItems {
  group?: boolean;
  icon?: string;
  title: string;
  items?: IMainMenuItems[];
  routeName?: string;
}
