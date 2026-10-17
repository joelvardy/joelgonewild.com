declare module 'markdown-data' {
    export function parse(input: string): {
        data: {
            meta: {
                title: string;
                date: Date;
                hero: string;
                heroalt?: string;
                intro: string;
            };
        };
        markdown: string;
    };
}

declare module 'handlebars-layouts' {
    import type Handlebars from 'handlebars';
    function layouts(handlebars: typeof Handlebars): Record<string, Handlebars.HelperDelegate>;
    export = layouts;
}
