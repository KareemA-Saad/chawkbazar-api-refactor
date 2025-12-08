TASK CONTEXT — Marvel E-commerce Package + Custom Puck Editor Integration

For Laravel project using the Marvel package — Full context for an AI-assistant inside VS Code / Cursor

📌 Goal

Integrate a custom block-based page builder inside a Laravel project that uses the Marvel e-commerce package, using Puck (React editor) to create editable components such as:

Heading blocks

Paragraph blocks

Image blocks

Section / layout blocks

Anything else required for editable CMS pages

The end result should let an admin user define dynamic page content (home page, about, landing pages, product highlights, etc.) using drag-and-drop components, stored in the Marvel database and rendered on the frontend.

📌 Existing Code (provided)

The current Puck config looks like this:

import type { Config } from "@measured/puck";

type Props = {
  HeadingBlock: { title: string };
};

export const config: Config<Props> = {
  components: {
    HeadingBlock: {
      fields: {
        title: { type: "text" },
      },
      defaultProps: {
        title: "Heading",
      },
      render: ({ title }) => (
        <div style={{ padding: 64 }}>
          <h1>{title}</h1>
        </div>
      ),
    },
  },
};

export default config;


You need to extend this system with new reusable components such as:

ParagraphBlock → textarea

ImageBlock → image upload URL

Call-To-Action block

Grid or two-column layout

Product highlights pulled from Marvel APIs

📌 Where This Will Live in Laravel

The Laravel project uses Marvel (an e-commerce package). The integration must work inside that environment.

Pages will be stored as JSON in database columns such as:

pages
- id
- slug
- title
- content (JSON from Puck editor)
- created_at
- updated_at


The backend must:

Accept JSON output from Puck editor.

Store it in the Marvel page table or a custom CMS table.

Provide an API route for retrieving and saving the content.

Send JSON to the React frontend.

The frontend must:

Render the Puck editor for admins.

Render the final HTML using Puck’s render engine for public users.

📌 New Component Example Needed (Paragraph)

Required component shape:

type Props = {
  ParagraphBlock: { text: string };
};


The fields should use:

text: { type: "textarea" }


Rendering example:

<div style={{ padding: 32 }}>
  <p>{text}</p>
</div>

📌 Frontend Requirements

Inside the React/Next.js project connected to Marvel, you must:

Import Puck

Register custom components inside puck.config.ts

Build a UI for page editing:

<Puck editor config={config} />


Build a UI for page rendering:

<Puck content={jsonFromLaravel} config={config} />


Add an API call to save content to Laravel:

await axios.post("/api/pages/update", { content });

📌 Backend Requirements (Laravel + Marvel)
1. Create a table for CMS pages

If Marvel already has a table for pages, reuse it. Otherwise create:

Schema::create('cms_pages', function (Blueprint $table) {
    $table->id();
    $table->string('slug')->unique();
    $table->string('title');
    $table->json('content')->nullable();
    $table->timestamps();
});

2. Create a controller

Handles saving JSON from the editor:

public function update(Request $request, $slug)
{
    $page = CmsPage::where('slug', $slug)->firstOrFail();
    $page->content = $request->content;
    $page->save();

    return response()->json(['success' => true]);
}

3. API endpoint

Marvel uses API routes under /api:

POST /api/pages/{slug}/update
GET /api/pages/{slug}

4. Authentication / roles

Only admins should access the editor.

📌 Component Architecture Requirement

Each block must include:

fields

Defines input types (text, textarea, image, select, etc.)

defaultProps

Defines default values when dropped into editor.

render

Returns JSX to render on the public website.

Example signature:

ParagraphBlock: {
  fields: { text: { type: "textarea" } },
  defaultProps: { text: "Lorem ipsum..." },
  render: ({ text }) => <p>{text}</p>,
}

📌 Document Goals for AI Assistant

The IDE or AI assistant should understand the tasks:

You’re working inside a Laravel + Marvel e-commerce project.

You’re integrating Puck as a CMS-like page builder.

You need multiple customizable blocks (Heading, Paragraph, Image, CTA, Layout).

You need API endpoints in Laravel to save/retrieve Puck JSON.

You need React components to edit and render pages.

You need the assistant to help generate:

New Puck components

Laravel models/migrations/controllers

React integration code

API communication code

Blade / Next.js rendering structure

This markdown is intended as the context injection so the IDE understands the full technical scope without re-explaining everything.